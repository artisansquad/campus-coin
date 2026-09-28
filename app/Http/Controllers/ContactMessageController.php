<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\InAppNotification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'subject' => ['nullable', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        $contactMessage = ContactMessage::create([
            'user_id' => $user?->id,
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'subject' => trim((string) ($validated['subject'] ?? 'General support')),
            'message' => trim($validated['message']),
            'status' => 'new',
        ]);

        $adminUsers = User::where('role', 'admin')->get();

        foreach ($adminUsers as $admin) {
            InAppNotification::create([
                'user_id' => $admin->id,
                'title' => 'New contact message',
                'message' => $contactMessage->message,
                'type' => 'contact_message',
                'sender_name' => $contactMessage->name,
                'sender_email' => $contactMessage->email,
                'contact_message_id' => $contactMessage->id,
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Thank you for reaching out! Your message has been sent successfully.');
    }
}
