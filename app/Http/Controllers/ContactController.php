<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('home.contact');
    }

    public function adminIndex()
    {
        $contacts = Contact::all(); // Fetch all submitted data
        return view('admin.Contact.contact', compact('contacts')); // Pass data to the admin view
    }
    
    /**
     * Store the contact form data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Please log in to send your message.');
        }

        // Validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^\d{10}$/'],
            'subject' => 'required',
            'message' => 'required'
        ]);

        // Collect validated data
        $data = $request->only(['name', 'email', 'phone', 'subject', 'message']);

        // Store the data
        Contact::create($data);

        // Redirect back with a success message
        return redirect()->back()->with(['success' => 'Thank you for contacting us. We will get back to you shortly.']);
    }
}
