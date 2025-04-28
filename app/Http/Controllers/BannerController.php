<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::all();
        return view('admin.banner.index', compact('banner'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner = new Banner();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/uploads/banner', $filename);
            $banner->image = $filename;
        }

        $banner->name = $request->input('name');
        $banner->save();

        return redirect()->back()->with('success', 'Banner added successfully.');
    }

    public function edit($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return redirect()->back()->with('error', 'Banner not found.');
        }

        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return redirect()->back()->with('error', 'Banner not found.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = 'assets/uploads/banner/' . $banner->image;
            if (File::exists($path)) {
                File::delete($path);
            }

            // Handling the image upload
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('assets/uploads/banner/', $filename);
            $banner->image = $filename;
        }

        $banner->name = $request->input('name');
        $banner->save();

        return redirect()->back()->with('success', 'Banner successfully updated.');
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return redirect()->back()->with('error', 'Banner not found.');
        }

        // Delete the image file if it exists
        if ($banner->image) {
            $path = 'assets/uploads/banner/' . $banner->image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        // Delete the banner record
        $banner->delete();

        return redirect()->back()->with('success', 'Banner deleted successfully.');
    }
}
