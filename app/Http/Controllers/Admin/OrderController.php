<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Admin\OrderStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');

        $orders = Order::query()
            ->with('user')
            ->withCount('items')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $statuses = [
            'pending',
            'confirmed',
            'processing',
            'shipped',
            'delivered',
            'cancelled',
        ];

        return view(
            'admin.orders.index',
            compact(
                'orders',
                'search',
                'status',
                'statuses'
            )
        );
    }

    /**
     * Display the specified order.
     */
	public function show(
	Order $order,
	OrderStatusService $statusService
	): View {
	$order->load([
		'user',
		'items.product',
		'items.dealer',
		'address',
		'payment',
		'statusHistories',
		'notificationLogs',
	]);

	$availableStatuses = $statusService->availableStatuses($order);

	return view(
		'admin.orders.show',
		compact('order', 'availableStatuses')
	);
	}

    /**
     * Update the order status.
     */
    public function updateStatus(
        Request $request,
        Order $order,
        OrderStatusService $statusService
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:pending,confirmed,processing,shipped,delivered,cancelled',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $statusService->updateStatus(
            $order,
            $validated['status'],
            $validated['notes'] ?? null
        );

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}