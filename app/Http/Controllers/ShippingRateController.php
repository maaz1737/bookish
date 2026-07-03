<?php

namespace App\Http\Controllers;

use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::paginate(10);

        return view("admin.shippingZone.index", compact("zones"));
    }

    public function create()
    {
        return view("admin.shippingZone.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "status" => "required|in:active,inactive",
        ]);

        ShippingZone::create([
            "name" => $request->name,
            "status" => $request->status
        ]);

        return redirect()->route('admin.shipping.index');
    }

    public function show(ShippingZone $zone)
    {
        $zone = ShippingZone::with('rates')->findOrFail($zone->id);
        return view('admin.shippingZone.show', compact('zone'));

    }

    public function edit(ShippingZone $zone)
    {
        return view("admin.shippingZone.edit", compact("zone"));
    }
    public function update(ShippingZone $zone, Request $request)
    {
        $request->validate([
            "name" => "required",
            "status" => "required|in:active,inactive",
        ]);

        $zone->update([
            "name" => $request->name,
            "status" => $request->status
        ]);

        return redirect()->route('admin.shipping.index');
    }
    public function destroy(ShippingZone $zone)
    {
        $zone->delete();
        return redirect()->route('admin.shipping.index');

    }



    public function shippingRateCreate(ShippingZone $zone)
    {
        return view('admin.shippingRate.create', compact('zone'));

    }



    public function shippingRateStore(Request $request)
    {
        $data = $request->validate([
            "shipping_zone_id" => "required|exists:shipping_zones,id",
            "name" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "min_order_amount" => "nullable|numeric|min:0",
            "free_shipping_min_order" => "nullable|numeric|min:0",
            "status" => "required|in:active,inactive",
            'estimated_days' => 'required|numeric',
        ]);

        ShippingZone::find($request->shipping_zone_id)->rates()->create($data);

        return redirect()->route("admin.shipping.show", $request->shipping_zone_id);

    }



}
