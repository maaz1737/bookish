<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Attribute;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Admins CAN see publisher -> makeVisible
        $products = Product::with('category', 'school')->latest()->paginate(20)
            ->through(fn($p) => $p->makeVisible('publisher'));

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create', $this->formData());
    }

    // public function store(StoreProductRequest $request)
    // {
    //     $data = $request->validated();
    //     $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
    //     $data['images'] = $this->storeImages($request);

    //     $product = Product::create($data);



    //     return redirect()->route('admin.products.index')->with('success', 'Product created.');
    // }

    public function store(StoreProductRequest $request)
    {


        try {

            $attribute = Attribute::all();

            DB::beginTransaction();

            $data = $request->validated();

            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
            $data['images'] = $this->storeImages($request);

            $product = Product::create($data);

            $this->syncProductBundle($product);

            DB::commit();

            if ($request->input('has_variant') && count($attribute) > 0) {

                return redirect()
                    ->route('admin.products.attribute.select', ['product' => $product->slug])
                    ->with('success', 'Product created.');
            } else {
                return redirect()->route('admin.products.index')->with('success', 'Product created.');
            }



        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }



    public function edit(Product $product)
    {
        $product->makeVisible('publisher');
        return view('admin.products.edit', array_merge($this->formData(), compact('product')));
    }
    private function syncProductBundle(Product $product)
    {
        BundleItem::where('product_id', $product->id)->delete();

        if (!$product->school_id || !$product->class_id) {
            return;
        }

        $bundle = Bundle::firstOrCreate(
            [
                'school_id' => $product->school_id,
                'class_id' => $product->class_id,
            ],
            [
                'total_price' => 0,
                'discount' => 0,
                'final_price' => 0,
                'is_active' => true,
            ]
        );

        // Prevent duplicate bundle item
        $bundle->items()->firstOrCreate([
            'product_id' => $product->id,
        ], [
            'quantity' => 1,
        ]);

        $items = $bundle->items()->with('product')->get();

        $totalPrice = 0;
        $totalDiscountPrice = 0;

        foreach ($items as $item) {
            if (!$item->product) {
                $item->delete();
                continue;
            }

            $price = $item->product->price * $item->quantity;

            $discountPrice = ($item->product->discount_price ?? $item->product->price)
                * $item->quantity;

            $totalPrice += $price;
            $totalDiscountPrice += $discountPrice;
        }
        $bundle->update([
            'total_price' => $totalPrice,
            'discount' => $totalDiscountPrice,
            'final_price' => $totalDiscountPrice,
        ]);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('images')) {
            $data['images'] = $this->storeImages($request);
        } else {
            unset($data['images']);
        }

        $product->update($data);

        $this->syncProductBundle($product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
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
            return back()->with('error', 'Please select at least one product to delete.');
        }

        $products = Product::whereIn('id', $ids)->get();

        if ($products->isEmpty()) {
            return back()->with('error', 'No products were found for deletion.');
        }

        $products->each->delete();

        return back()->with('success', count($products) . ' product(s) deleted.');
    }

    private function formData(): array
    {
        return [
            'categories' => Category::where('is_active', true)->whereNull('parent_id')->get(),
            'schools' => School::where('is_active', true)->get(),
            'sub_category' => collect(),
            'classes' => collect(),
        ];
    }

    private function storeImages(Request $request): array
    {
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
        }

        $paths = [];

        foreach ((array) $request->file('images', []) as $file) {
            $paths[] = $file->store('products', 'public');
        }
        return $paths;
    }

    public function bulkUploadShow()
    {
        return view('admin.products.bulk');
    }

    public function bulkUploadTemplate()
    {
        $headers = [
            'Product Name',
            'Category',
            'School',
            'Class',
            'Publisher',
            'Base Price',
            'Discount Price',
            'Stock',
            'Low Stock Threshold',
            'Description'
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            // Add a sample row
            fputcsv($file, [
                'Class 5 Mathematics Book',
                'Books',
                'Fazaia School System',
                'Class 5',
                'National Book Foundation',
                '800',
                '750',
                '50',
                '5',
                'Official textbook recommended by Fazaia.'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=products_bulk_template.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
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
            $headers = fgetcsv($handle, 1000, ',');

            if ($headers) {
                $headers = array_map(function ($h) {
                    return trim(strtolower(str_replace([' ', '_', '-'], '', $h)));
                }, $headers);
            }

            $expected = [
                'productname' => 'Product Name',
                'category' => 'Category',
                'school' => 'School',
                'class' => 'Class',
                'publisher' => 'Publisher',
                'baseprice' => 'Base Price',
                'discountprice' => 'Discount Price',
                'stock' => 'Stock',
                'lowstockthreshold' => 'Low Stock Threshold',
                'description' => 'Description'
            ];

            $rowCount = 1;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $rowCount++;

                if (count($headers) !== count($data)) {
                    $errors[] = "Row {$rowCount}: Column count mismatch. Expected " . count($headers) . " columns.";
                    continue;
                }

                $rowRaw = array_combine($headers, $data);

                $row = [];
                foreach ($expected as $key => $label) {
                    $row[$key] = isset($rowRaw[$key]) ? trim($rowRaw[$key]) : null;
                }

                $rowErrors = [];

                $name = $row['productname'];
                if (empty($name)) {
                    $rowErrors[] = "Product Name is missing.";
                }

                $categoryName = $row['category'];
                $category = null;
                if (empty($categoryName)) {
                    $rowErrors[] = "Category is required.";
                } else {
                    $category = Category::where('name', $categoryName)->first();
                    if (!$category) {
                        $rowErrors[] = "Category '{$categoryName}' does not exist in the system.";
                    }
                }

                $basePrice = $row['baseprice'];
                if (empty($basePrice)) {
                    $rowErrors[] = "Base Price is required.";
                } elseif (!is_numeric($basePrice)) {
                    $rowErrors[] = "Base Price must be a valid number.";
                }

                $discountPrice = $row['discountprice'];
                if (!empty($discountPrice)) {
                    if (!is_numeric($discountPrice)) {
                        $rowErrors[] = "Discount Price must be a valid number.";
                    } elseif (is_numeric($basePrice) && $discountPrice > $basePrice) {
                        $rowErrors[] = "Discount Price cannot be greater than Base Price.";
                    }
                }

                $stock = $row['stock'];
                if ($stock === '' || $stock === null) {
                    $stock = 0;
                } elseif (!is_numeric($stock)) {
                    $rowErrors[] = "Stock must be a valid number.";
                }

                $lowStock = $row['lowstockthreshold'];
                if ($lowStock === '' || $lowStock === null) {
                    $lowStock = 5;
                } elseif (!is_numeric($lowStock)) {
                    $rowErrors[] = "Low-stock threshold must be numeric.";
                }

                $schoolName = $row['school'];
                $school = null;
                if (!empty($schoolName)) {
                    $school = School::where('name', $schoolName)->first();
                    if (!$school) {
                        $rowErrors[] = "School name '{$schoolName}' does not match any existing school.";
                    }
                }

                $className = $row['class'];
                $schoolClass = null;
                if (!empty($className)) {
                    $classQuery = SchoolClass::where('name', $className);
                    if ($school) {
                        $classQuery->where('school_id', $school->id);
                    }
                    $schoolClass = $classQuery->first();
                    if (!$schoolClass) {
                        if ($school) {
                            $rowErrors[] = "Class '{$className}' does not exist for school '{$schoolName}'.";
                        } else {
                            $rowErrors[] = "Class '{$className}' does not match any existing class.";
                        }
                    }
                }

                if (!empty($name)) {
                    $existing = Product::where('name', $name);
                    if ($school) {
                        $existing->where('school_id', $school->id);
                    } else {
                        $existing->whereNull('school_id');
                    }
                    if ($schoolClass) {
                        $existing->where('class_id', $schoolClass->id);
                    } else {
                        $existing->whereNull('class_id');
                    }
                    if ($existing->exists()) {
                        $rowErrors[] = "Duplicate product found in database.";
                    }

                    foreach ($validRows as $vr) {
                        if (
                            $vr['name'] === $name &&
                            $vr['school_id'] === ($school ? $school->id : null) &&
                            $vr['class_id'] === ($schoolClass ? $schoolClass->id : null)
                        ) {
                            $rowErrors[] = "Duplicate product found in the uploaded file.";
                            break;
                        }
                    }
                }

                $rowObj = [
                    'row_num' => $rowCount,
                    'name' => $name,
                    'category_name' => $categoryName,
                    'category_id' => $category ? $category->id : null,
                    'school_name' => $schoolName,
                    'school_id' => $school ? $school->id : null,
                    'class_name' => $className,
                    'class_id' => $schoolClass ? $schoolClass->id : null,
                    'publisher' => $row['publisher'],
                    'price' => (float) $basePrice,
                    'discount_price' => !empty($discountPrice) ? (float) $discountPrice : null,
                    'stock' => (int) $stock,
                    'low_stock_threshold' => (int) $lowStock,
                    'description' => $row['description'],
                    'errors' => $rowErrors
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
            session()->put('bulk_import_products', $validRows);
        } else {
            session()->forget('bulk_import_products');
        }

        return view('admin.products.bulk', [
            'rows' => $rows,
            'bulkErrors' => $errors
        ]);
    }

    public function bulkUploadImport(Request $request)
    {
        $products = session()->get('bulk_import_products');

        if (empty($products)) {
            return redirect()->route('admin.products.bulk.show')->with('error', 'No valid products found to import. Please upload a valid CSV first.');
        }

        try {
            DB::beginTransaction();

            foreach ($products as $p) {
                $slug = Str::slug($p['name']) . '-' . Str::random(5);

                $product = Product::create([
                    'name' => $p['name'],
                    'slug' => $slug,
                    'category_id' => $p['category_id'],
                    'school_id' => $p['school_id'],
                    'class_id' => $p['class_id'],
                    'price' => $p['price'],
                    'discount_price' => $p['discount_price'],
                    'stock' => $p['stock'],
                    'low_stock_threshold' => $p['low_stock_threshold'],
                    'publisher' => $p['publisher'],
                    'description' => $p['description'],
                    'images' => [],
                    'is_active' => true
                ]);

                $this->syncProductBundle($product);
            }

            DB::commit();

            session()->forget('bulk_import_products');

            return redirect()->route('admin.products.index')
                ->with('success', count($products) . ' products imported successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.products.bulk.show')->with('error', 'Failed to import products: ' . $e->getMessage());
        }
    }
}
