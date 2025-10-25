<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $notifications = $user->notifications()->latest()->paginate(15);
        return view('frontend.notifications.index', compact('notifications'));
    }

    public function markRead(Request $request, string $id): RedirectResponse
    {
        $user = $request->user();
        /** @var DatabaseNotification|null $notification */
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification && $notification->read_at === null) {
            $notification->markAsRead();
        }
        return back();
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();
        return back();
    }
}
