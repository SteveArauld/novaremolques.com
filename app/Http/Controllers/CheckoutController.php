<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderConfirmation;
use App\Mail\AdminOrderNotification;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function processOrder(Request $request)
    {
        $validated = $request->validate([
            'billing.firstName' => 'required|string|max:255',
            'billing.lastName' => 'required|string|max:255',
            'billing.company' => 'nullable|string|max:255',
            'billing.country' => 'required|string|max:100',
            'billing.address' => 'required|string|max:500',
            'billing.address2' => 'nullable|string|max:500',
            'billing.city' => 'required|string|max:255',
            'billing.state' => 'nullable|string|max:255',
            'billing.postcode' => 'required|string|max:20',
            'billing.phone' => 'required|string|max:30',
            'billing.email' => 'required|email|max:255',
            'shipping.firstName' => 'nullable|string|max:255',
            'shipping.lastName' => 'nullable|string|max:255',
            'shipping.address' => 'nullable|string|max:500',
            'shipping.city' => 'nullable|string|max:255',
            'shipping.postcode' => 'nullable|string|max:20',
            'shipping.country' => 'nullable|string|max:100',
            'payment' => 'required|string|in:transfer,card,paypal',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'subtotal' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'coupon' => 'nullable|string|max:50',
        ]);

        try {
            $orderNumber = 'CMD-' . strtoupper(uniqid()) . '-' . date('Ymd');

            $order = Order::create([
                'order_number' => $orderNumber,
                'status' => 'pending',
                'payment_method' => $validated['payment'],
                'payment_status' => 'pending',
                'subtotal' => $validated['subtotal'],
                'shipping_cost' => $validated['shipping_cost'],
                'tax' => $validated['tax'],
                'total' => $validated['total'],
                'coupon_code' => $validated['coupon'] ?? null,
                'notes' => $validated['notes'] ?? null,
                
                'billing_first_name' => $validated['billing']['firstName'],
                'billing_last_name' => $validated['billing']['lastName'],
                'billing_company' => $validated['billing']['company'] ?? null,
                'billing_country' => $validated['billing']['country'],
                'billing_address_1' => $validated['billing']['address'],
                'billing_address_2' => $validated['billing']['address2'] ?? null,
                'billing_city' => $validated['billing']['city'],
                'billing_state' => $validated['billing']['state'] ?? null,
                'billing_postcode' => $validated['billing']['postcode'],
                'billing_phone' => $validated['billing']['phone'],
                'billing_email' => $validated['billing']['email'],
                
                'shipping_first_name' => $validated['shipping']['firstName'] ?? $validated['billing']['firstName'],
                'shipping_last_name' => $validated['shipping']['lastName'] ?? $validated['billing']['lastName'],
                'shipping_address_1' => $validated['shipping']['address'] ?? $validated['billing']['address'],
                'shipping_city' => $validated['shipping']['city'] ?? $validated['billing']['city'],
                'shipping_postcode' => $validated['shipping']['postcode'] ?? $validated['billing']['postcode'],
                'shipping_country' => $validated['shipping']['country'] ?? $validated['billing']['country'],
                
                'items' => $validated['items'],
                
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            try {
                Mail::to($order->billing_email)->send(new OrderConfirmation($order));
                Log::info(__('checkout.log.client_email_sent', ['email' => $order->billing_email]));
            } catch (\Exception $e) {
                Log::error(__('checkout.log.client_email_error', ['error' => $e->getMessage()]));
            }

            try {
                $adminEmail = config('mail.admin_email', 'admin@votresite.com');
                Mail::to($adminEmail)->send(new AdminOrderNotification($order));
                Log::info(__('checkout.log.admin_email_sent', ['email' => $adminEmail]));
            } catch (\Exception $e) {
                Log::error(__('checkout.log.admin_email_error', ['error' => $e->getMessage()]));
            }

            return response()->json([
                'success' => true,
                'message' => __('checkout.response.order_created'),
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total' => $order->total,
                    'status' => $order->status,
                    'created_at' => $order->created_at,
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error(__('checkout.log.order_error', ['error' => $e->getMessage()]));
            
            return response()->json([
                'success' => false,
                'message' => __('checkout.response.order_error'),
            ], 500);
        }
    }
}