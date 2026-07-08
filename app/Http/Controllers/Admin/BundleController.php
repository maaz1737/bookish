<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBundleRequest;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use App\Models\School;
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
            'schools' => School::with('classes')->get(),
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
        dd($request);
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
}
