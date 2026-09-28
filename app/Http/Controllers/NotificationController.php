<?php

namespace App\Http\Controllers;

use App\Models\InAppNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(InAppNotification $notification): RedirectResponse
    {
        $user = Auth::user();
        if ($notification->user_id !== $user->id) {
            abort(403);
        }

        $notification->is_read = true;
        $notification->save();

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead(): RedirectResponse
    {
        $user = Auth::user();
        $user->notifications()->where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }
}
