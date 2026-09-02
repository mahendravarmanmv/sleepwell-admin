<?php

namespace App\Services\Admin;

use App\Models\Order;
use Illuminate\Validation\ValidationException;

class OrderStatusService
{
    /**
     * Documented SleepWell order lifecycle.
     */
    protected array $forwardTransitions = [
        'pending' => 'confirmed',
        'confirmed' => 'processing',
        'processing' => 'shipped',
        'shipped' => 'delivered',
    ];

    /**
     * Update an order status and create an audit entry.
     */
    public function updateStatus(
        Order $order,
        string $newStatus,
        ?string $notes = null
    ): void {
        $currentStatus = $order->status;

        $allowedStatuses = [
            'pending',
            'confirmed',
            'processing',
            'shipped',
            'delivered',
            'cancelled',
        ];

        if (!in_array($newStatus, $allowedStatuses, true)) {
            throw ValidationException::withMessages([
                'status' => 'Invalid order status.',
            ]);
        }

        if ($currentStatus === $newStatus) {
            throw ValidationException::withMessages([
                'status' => 'The order is already in this status.',
            ]);
        }

        if (in_array($currentStatus, ['delivered', 'cancelled'], true)) {
            throw ValidationException::withMessages([
                'status' => 'This order can no longer be updated.',
            ]);
        }

        $expectedNextStatus = $this->forwardTransitions[$currentStatus] ?? null;

        $isValidForwardTransition =
            $expectedNextStatus === $newStatus;

        $isCancellation =
            $newStatus === 'cancelled';

        if (!$isValidForwardTransition && !$isCancellation) {
            throw ValidationException::withMessages([
                'status' => "Order cannot move from {$currentStatus} to {$newStatus}.",
            ]);
        }

        $order->status = $newStatus;
        $order->save();

        $order->statusHistories()->create([
            'status' => $newStatus,
            'notes' => $notes ?: $this->defaultNote($newStatus),
        ]);
    }

    protected function defaultNote(string $status): string
    {
        return match ($status) {
            'confirmed' => 'Order confirmed by admin.',
            'processing' => 'Order moved to processing.',
            'shipped' => 'Order marked as shipped.',
            'delivered' => 'Order marked as delivered.',
            'cancelled' => 'Order cancelled by admin.',
            default => 'Order status updated.',
        };
    }

    /**
     * Return the next valid statuses for the current order.
     */
    public function availableStatuses(Order $order): array
    {
        $statuses = [];

        if (isset($this->forwardTransitions[$order->status])) {
            $statuses[] = $this->forwardTransitions[$order->status];
        }

        if (!in_array($order->status, ['delivered', 'cancelled'], true)) {
            $statuses[] = 'cancelled';
        }

        return $statuses;
    }
}