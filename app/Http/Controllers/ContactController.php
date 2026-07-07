<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage; // Model ko top par import zaroor karein

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        // 1. Data ko Validate karein
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        // 2. Database mein save karein
        ContactMessage::create($validatedData);

        // 3. Wapis contact page par bheinjein success message ke saath
        return back()->with('success', 'Thank you! Your message has been saved successfully.');
    }
    // public function store(Request $request)
    // {
    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'phone' => 'nullable|string|max:20',
    //         'message' => 'required|string',
    //     ]);

    //     // Create a new contact message record in the database
    //     ContactMessage::create($validatedData);

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Thank you! Your message has been saved successfully.');
    // }
}