<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'inquiry_type' => ['nullable', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
        ]);

        ContactInquiry::create($validated);

        return back()->with('status', 'Thank you for contacting us. Our team will reach out shortly.');
    }
}
