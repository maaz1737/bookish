<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }
    public function create()
    {
        return view('admin.banners.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'nullable|string|max:255', // <-- Yahan 'title' check karein
            'link' => 'nullable|url',
            'order' => 'nullable|integer'
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,       // <-- 'tittle' ko 'title' kr dein (Line 34)
            'image_path' => $path,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner successfully created!');
    }
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'nullable|string|max:255', // <-- Yahan 'title' hona chahiye
            'link' => 'nullable|url',
            'order' => 'nullable|integer'
        ]);

        $path = $banner->image_path;
        if ($request->hasFile('image')) {
            // Purani image delete karein
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($banner->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($banner->image_path);
            }
            $path = $request->file('image')->store('banners', 'public');
        }

        // Line 65-66 ka fix yahan hai:
        $banner->update([
            'title' => $request->title, // <-- 'tittle' ko badal kar 'title' kar diya hai
            'image_path' => $path,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner successfully updated!');
    }

    public function destroy(Banner $banner)
    {
        if (Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner successfully deleted!');
    }
}
