<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banner=banner::all();
        return view('admin.banner.index',Compact('banner'));
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
        $banner = new banner();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/banner', $filename);
            $banner->image = $filename;
        }
        $banner->name = $request->input('name');
        $banner->save();
        return redirect()->route('banners.index')->with('valid', "Banner added successfully");
    }
    public function edit($id)
    {
        $banner=banner::find($id);
        return view('admin.banner.edit',compact('banner'));
    }
    public function update(Request $request, $id)
    {
    $banner = banner::find($id);
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    if (!$banner) {
        return redirect('dashboard')->with('invalid', 'Banner not found.');
    }

    if ($request->hasFile('image')) 
    {
        $path = 'assets/uploads/banner/' . $banner->image;
        if (File::exists($path)) 
        {
            File::delete($path);
        }
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '.' . $ext;
        $file->move('assets/uploads/banner/', $filename);
        $banner->image = $filename;
    }

    $banner->name = $request->input('name') ?? $banner->name;
    $banner->update();
    
    return redirect('banners')->with('valid', 'Banner Successfully Updated');
}

public function destroy($id)
{
    $banner = Banner::find($id);
    if ($banner) {
        // Check if the banner image exists and delete it
        if ($banner->image) {
            $path = 'assets/uploads/banner/' . $banner->image;
            if (File::exists($path)) {
                File::delete($path);  // Delete the file
            }
        }

        // Delete the banner record
        $banner->delete();

        return redirect('banners')->with('invalid', 'Banner Deleted Successfully');
    } else {
        return redirect('banners')->with('invalid', 'Banner not found.');
    }
}
}
