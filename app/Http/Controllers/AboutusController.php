<?php

namespace App\Http\Controllers;

use App\Models\Aboutus;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class AboutusController extends Controller
{
    protected $about;
    
    public function aboutus()
    {
        $about = Aboutus::first();
        return view('admin.aboutus.create', compact('about'));
    }    
    public function view()
    {
    $about = Aboutus::first();

    if ($about) {
        $about->aboutus = nl2br($about->aboutus);
    } else {
        $about = new Aboutus();
        $about->aboutus = "UPLOADER HAS NOT UPLOADED ANYTHING ABOUT Resort";
    }

    return view('home.aboutus', compact('about')); // Correct view file name
    }

    
    public function aboutusupdate(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'aboutus' => 'required|string',
        'phone' => ['required', 'regex:/^\d{10}$/']
    ]);

    $about = Aboutus::firstOrNew();
    $about->phone = $request->input('phone');
    $about->email = $request->input('email');
    $about->aboutus = $request->input('aboutus');

    if ($request->hasFile('image')) {
        $destination = 'uploads/aboutus/' . $about->image;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move('uploads/aboutus/', $filename);
        $about->image = $filename;
    } else {
        $about->image = $about->image ?? 'default.jpg'; // Set a default value if no image is provided
    }

    $about->save();

    return redirect()->back()->with('Success', 'Aboutus Updated Successfully');
} 
}