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
use Illuminate\Support\Facades\DB;

class BundleController extends Controller
{
    public function __construct(private BundlePricingService $pricing) {}

    public function index()
    {
        $bundles = Bundle::with('school', 'schoolClass')->withCount('items')->latest()->paginate(20);
        return view('admin.bundles.index', compact('bundles'));
    }

    public function create()
    {
        return view('admin.bundles.create', [
            'schools'  => School::with('classes')->get(),
            // Only book-category products belong in bundles
            'products' => Product::active()->whereHas('category', fn ($q) => $q->where('type', 'book'))->get(),
        ]);
    }

    // UI Sequence: Select School -> Select Class -> Add Books -> Auto-Calculate
    public function store(StoreBundleRequest $request)
    {
        $bundle = DB::transaction(function () use ($request) {
            $bundle = Bundle::updateOrCreate(
                ['school_id' => $request->school_id, 'class_id' => $request->class_id],
                ['discount' => $request->discount, 'is_active' => $request->boolean('is_active', true)]
            );

            $bundle->items()->delete();
            foreach ($request->items as $item) {
                BundleItem::create([
                    'bundle_id'  => $bundle->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                ]);
            }

            // Auto-calculate total + discounted final price
            return $this->pricing->recalculate($bundle);
        });

        return redirect()->route('admin.bundles.index')
            ->with('success', "Bundle saved. Final price: {$bundle->final_price} PKR.");
    }

    public function destroy(Bundle $bundle)
    {
        $bundle->delete();
        return back()->with('success', 'Bundle deleted.');
    }
}
