<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderPaymentController extends Controller
{
    /**
     * Update payment information for an order.
     */
    public function update(
        Request $request,
        Order $order
    ): RedirectResponse {
        $validated = $request->validate([
            'payment_status' => [
                'required',
                'string',
                'in:pending,paid,failed',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],
            'transaction_reference' => [
                'nullable',
                'string',
                'max:255',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'paid_at' => [
                'nullable',
                'date',
            ],
        ]);

        if ($validated['payment_status'] === 'paid') {
            if ((float) $validated['amount'] <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Paid amount must be greater than zero.',
                ]);
            }

            if (empty($validated['paid_at'])) {
                $validated['paid_at'] = now();
            }
        } else {
            $validated['paid_at'] = null;
        }

        DB::transaction(function () use ($order, $validated) {

            $payment = $order->payment;

            if ($payment) {

                $payment->update([
                    'payment_method' => $order->payment_method,
                    'payment_status' => $validated['payment_status'],
                    'amount' => $validated['amount'],
                    'transaction_reference' =>
                        $validated['transaction_reference'] ?? null,
                    'notes' =>
                        $validated['notes'] ?? null,
                    'paid_at' =>
                        $validated['paid_at'] ?? null,
                ]);

            } else {

                $order->payment()->create([
                    'payment_method' => $order->payment_method,
                    'payment_status' => $validated['payment_status'],
                    'amount' => $validated['amount'],
                    'transaction_reference' =>
                        $validated['transaction_reference'] ?? null,
                    'notes' =>
                        $validated['notes'] ?? null,
                    'paid_at' =>
                        $validated['paid_at'] ?? null,
                ]);

            }

            $order->update([
                'payment_status' => $validated['payment_status'],
            ]);
        });

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Payment information updated successfully.');
    }
}