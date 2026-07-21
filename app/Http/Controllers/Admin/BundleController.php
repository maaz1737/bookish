<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBundleRequest;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use App\Models\School;
use App\Models\SchoolClass;
use App\Services\BundlePricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BundleController extends Controller
{
    public function __construct(private BundlePricingService $pricing)
    {
    }

    public function index()
    {
        $bundles = Bundle::with('school', 'schoolClass')->withCount('items')->latest()->paginate(20);
        return view('admin.bundles.index', compact('bundles'));
    }

    public function create()
    {
        return view('admin.bundles.create', [
            'schools'  => School::with('classes')->get(),
            'products' => Product::active()->get(),
        ]);
    }

    public function store(StoreBundleRequest $request)
    {
        $bundle = DB::transaction(function () use ($request) {
            $bundle = Bundle::create([
                'name'      => $request->name,
                'school_id' => $request->school_id ?: null,
                'class_id'  => $request->class_id ?: null,
                'discount'  => $request->discount,
                'is_active' => $request->boolean('is_active', true),
            ]);

            foreach ($request->items as $item) {
                BundleItem::create([
                    'bundle_id'  => $bundle->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                ]);
            }

            return $this->pricing->recalculate($bundle);
        });

        return redirect()->route('admin.bundles.index')
            ->with('success', "Bundle saved. Final price: {$bundle->final_price} PKR.");
    }

    public function edit(Bundle $bundle)
    {
        return view('admin.bundles.edit', [
            'schools'  => School::with('classes')->get(),
            'products' => Product::active()->get(),
            'bundle'   => $bundle->load([
                'school',
                'schoolClass',
                'items'
            ])->loadCount('items')
        ]);
    }

    public function update(StoreBundleRequest $request, Bundle $bundle)
    {
        $bundle = DB::transaction(function () use ($request, $bundle) {
            $bundle->update([
                'name'      => $request->name,
                'school_id' => $request->school_id ?: null,
                'class_id'  => $request->class_id ?: null,
                'discount'  => $request->discount,
                'is_active' => $request->boolean('is_active', true),
            ]);

            $bundle->items()->delete();

            foreach ($request->items as $item) {
                BundleItem::create([
                    'bundle_id'  => $bundle->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                ]);
            }

            return $this->pricing->recalculate($bundle);
        });

        return redirect()
            ->route('admin.bundles.index')
            ->with('success', "Bundle updated. Final price: {$bundle->final_price} PKR.");
    }

    public function destroy(Bundle $bundle)
    {
        $bundle->delete();
        return back()->with('success', 'Bundle deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = collect($request->input('selected', []))
            ->filter(fn($id) => is_numeric($id))
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        if (empty($ids)) {
            return back()->with('error', 'Please select at least one bundle to delete.');
        }

        $bundles = Bundle::whereIn('id', $ids)->get();

        if ($bundles->isEmpty()) {
            return back()->with('error', 'No bundles were found for deletion.');
        }

        $bundles->each->delete();

        return back()->with('success', count($bundles) . ' bundle(s) deleted.');
    }

    /* -------------------------- BULK UPLOAD METHODS -------------------------- */

    public function bulkUploadShow()
    {
        return view('admin.bundles.bulk');
    }

    public function bulkUploadTemplate()
    {
        $headers = [
            'Bundle Name',
            'School',
            'Class',
            'Discount Percent',
            'Products'
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            // Add sample rows
            fputcsv($file, [
                'Class 5 Complete Syllabus Bundle',
                'Fazaia School System',
                'Class 5',
                '10',
                'Class 5 Mathematics Book | English Reader Class 5 | Urdu Guldasta Class 5'
            ]);
            fputcsv($file, [
                'Class 6 Science Package',
                'Army Public School (APS)',
                'Class 6',
                '15',
                'General Science Class 6 : 1 | Computer Studies Class 6 : 1'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=bundles_bulk_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ]);
    }

    public function bulkUploadPost(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $rows = [];
        $errors = [];
        $validRows = [];

        if (($handle = fopen($path, 'r')) !== false) {
            $headers = fgetcsv($handle, 2000, ',');

            if ($headers) {
                $headers = array_map(function ($h) {
                    return trim(strtolower(str_replace([' ', '_', '-'], '', $h)));
                }, $headers);
            }

            $expected = [
                'bundlename'      => 'Bundle Name',
                'school'          => 'School',
                'class'           => 'Class',
                'discountpercent' => 'Discount Percent',
                'products'        => 'Products'
            ];

            $rowCount = 1;
            while (($data = fgetcsv($handle, 2000, ',')) !== false) {
                $rowCount++;

                // Skip empty lines
                if (empty(array_filter($data))) {
                    continue;
                }

                if (count($headers) !== count($data)) {
                    $errors[] = "Row {$rowCount}: Column count mismatch. Expected " . count($headers) . " columns.";
                    continue;
                }

                $rowRaw = array_combine($headers, $data);

                $row = [];
                foreach ($expected as $key => $label) {
                    $row[$key] = isset($rowRaw[$key]) ? trim($rowRaw[$key]) : null;
                }

                // Handle alternative header names
                if (empty($row['discountpercent']) && isset($rowRaw['discount'])) {
                    $row['discountpercent'] = trim($rowRaw['discount']);
                }

                $rowErrors = [];

                $name = $row['bundlename'];
                if (empty($name)) {
                    $rowErrors[] = "Bundle Name is missing.";
                }

                $schoolName = $row['school'];
                $school = null;
                if (!empty($schoolName)) {
                    $school = School::where('name', 'LIKE', $schoolName)->first();
                    if (!$school) {
                        $rowErrors[] = "School '{$schoolName}' does not exist.";
                    }
                }

                $className = $row['class'];
                $schoolClass = null;
                if (!empty($className)) {
                    $classQuery = SchoolClass::query();
                    if ($school) {
                        $classQuery->where('school_id', $school->id);
                    }
                    $classQuery->where('name', 'LIKE', $className);
                    $schoolClass = $classQuery->first();
                    if (!$schoolClass) {
                        if ($school) {
                            $rowErrors[] = "Class '{$className}' does not exist for school '{$schoolName}'.";
                        } else {
                            $rowErrors[] = "Class '{$className}' does not match any existing class.";
                        }
                    }
                }

                $discount = $row['discountpercent'];
                if ($discount === '' || $discount === null) {
                    $discount = 0;
                } elseif (!is_numeric($discount)) {
                    $rowErrors[] = "Discount must be a valid number.";
                } elseif ($discount < 0 || $discount > 100) {
                    $rowErrors[] = "Discount percent must be between 0 and 100.";
                }

                $productsString = $row['products'];
                $parsedProducts = [];
                if (empty($productsString)) {
                    $rowErrors[] = "At least one Product is required for a Bundle.";
                } else {
                    // Split products by pipe '|' or semicolon ';'
                    $productItems = preg_split('/[|;]/', $productsString);
                    foreach ($productItems as $itemStr) {
                        $itemStr = trim($itemStr);
                        if (empty($itemStr)) continue;

                        $qty = 1;
                        $prodSearch = $itemStr;

                        // Check quantity format: "Product Name : 2" or "Product Name x 2"
                        if (preg_match('/^(.*?)\s*[:x]\s*(\d+)$/i', $itemStr, $matches)) {
                            $prodSearch = trim($matches[1]);
                            $qty = (int) $matches[2];
                        }

                        $productQuery = Product::where('name', 'LIKE', $prodSearch);
                        if (is_numeric($prodSearch)) {
                            $productQuery->orWhere('id', (int) $prodSearch);
                        }
                        $product = $productQuery->first();

                        if (!$product) {
                            $rowErrors[] = "Product '{$prodSearch}' was not found in catalog.";
                        } else {
                            $parsedProducts[] = [
                                'product_id'      => $product->id,
                                'product_name'    => $product->name,
                                'effective_price' => (float) $product->effectivePrice(),
                                'quantity'        => $qty > 0 ? $qty : 1
                            ];
                        }
                    }

                    if (empty($parsedProducts) && empty($rowErrors)) {
                        $rowErrors[] = "No valid products found in the products list.";
                    }
                }

                // Compute prices
                $totalPrice = 0;
                foreach ($parsedProducts as $pItem) {
                    $totalPrice += $pItem['effective_price'] * $pItem['quantity'];
                }
                $discPct = (float) $discount;
                $finalPrice = $totalPrice - ($totalPrice * ($discPct / 100));

                $rowObj = [
                    'row_num'      => $rowCount,
                    'name'         => $name,
                    'school_name'  => $schoolName,
                    'school_id'    => $school ? $school->id : null,
                    'class_name'   => $className,
                    'class_id'     => $schoolClass ? $schoolClass->id : null,
                    'discount'     => (float) $discount,
                    'total_price'  => round($totalPrice, 2),
                    'final_price'  => round($finalPrice, 2),
                    'products'     => $parsedProducts,
                    'products_raw' => $productsString,
                    'errors'       => $rowErrors
                ];

                $rows[] = $rowObj;

                if (count($rowErrors) === 0) {
                    $validRows[] = $rowObj;
                } else {
                    $errors[] = "Row {$rowCount}: " . implode(' ', $rowErrors);
                }
            }
            fclose($handle);
        }

        if (count($errors) === 0) {
            session()->put('bulk_import_bundles', $validRows);
        } else {
            session()->forget('bulk_import_bundles');
        }

        return view('admin.bundles.bulk', [
            'rows'       => $rows,
            'bulkErrors' => $errors
        ]);
    }

    public function bulkUploadImport(Request $request)
    {
        $bundles = session()->get('bulk_import_bundles');

        if (empty($bundles)) {
            return redirect()
                ->route('admin.bundles.bulk.show')
                ->with('error', 'No valid bundle records found in session. Please re-upload your file.');
        }

        $importedCount = 0;

        DB::transaction(function () use ($bundles, &$importedCount) {
            foreach ($bundles as $row) {
                $bundle = Bundle::create([
                    'name'      => $row['name'],
                    'school_id' => $row['school_id'],
                    'class_id'  => $row['class_id'],
                    'discount'  => $row['discount'],
                    'is_active' => true,
                ]);

                foreach ($row['products'] as $pItem) {
                    BundleItem::create([
                        'bundle_id'  => $bundle->id,
                        'product_id' => $pItem['product_id'],
                        'quantity'   => $pItem['quantity'],
                    ]);
                }

                $this->pricing->recalculate($bundle);
                $importedCount++;
            }
        });

        session()->forget('bulk_import_bundles');

        return redirect()
            ->route('admin.bundles.index')
            ->with('success', "Successfully imported {$importedCount} bundle(s).");
    }
}
