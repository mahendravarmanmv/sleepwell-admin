<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderNotificationLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');
        $channel = $request->input('channel', '');

        $notifications = OrderNotificationLog::query()
            ->with([
                'order.user',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {

                    $query->where(
                        'recipient',
                        'like',
                        "%{$search}%"
                    );

                    $query->orWhere(
                        'notification_type',
                        'like',
                        "%{$search}%"
                    );

                    $query->orWhereHas('order', function ($query) use ($search) {

                        $query->where(
                            'order_number',
                            'like',
                            "%{$search}%"
                        );

                        $query->orWhereHas('user', function ($query) use ($search) {

                            $query->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                            $query->orWhere(
                                'email',
                                'like',
                                "%{$search}%"
                            );

                            $query->orWhere(
                                'phone',
                                'like',
                                "%{$search}%"
                            );
                        });
                    });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($channel !== '', function ($query) use ($channel) {
                $query->where('channel', $channel);
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $statuses = OrderNotificationLog::query()
            ->whereNotNull('status')
            ->where('status', '!=', '')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        $channels = OrderNotificationLog::query()
            ->whereNotNull('channel')
            ->where('channel', '!=', '')
            ->distinct()
            ->orderBy('channel')
            ->pluck('channel');

        return view(
            'admin.notifications.index',
            compact(
                'notifications',
                'search',
                'status',
                'channel',
                'statuses',
                'channels'
            )
        );
    }
}