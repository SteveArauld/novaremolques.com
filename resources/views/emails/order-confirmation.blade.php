{{-- resources/views/emails/order-confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; }
        .header { background: #FC6702; color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .body { padding: 30px; }
        .order-number { background: #f0f7ff; border-left: 4px solid #3498db; padding: 15px; margin: 20px 0; }
        .section { margin: 25px 0; }
        .section h3 { color: #FC6702; border-bottom: 2px solid #FC6702; padding-bottom: 10px; }
        .address-box { background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #f8f9fa; padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6; }
        td { padding: 10px; border-bottom: 1px solid #f0f0f0; }
        .total-row { font-weight: bold; font-size: 18px; background: #fff8f0; }
        .total-row td { border-top: 2px solid #FC6702; }
        .amount { color: #FC6702; font-weight: bold; }
        .btn { display: inline-block; padding: 12px 30px; background: #FC6702; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 10px 5px; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>{{ __('email.order.confirmation_title') }}</p>
        </div>
        
        <div class="body">
            <h2 style="text-align: center; color: #4CAF50;">{{ __('email.order.thank_you') }}</h2>
            
            <p>{{ __('email.order.greeting', ['name' => $order->full_name]) }}</p>
            <p>{{ __('email.order.received') }}</p>
            
            <div class="order-number">
                <strong>{{ __('email.order.order_number', ['number' => $order->order_number]) }}</strong><br>
                <small>{{ __('email.order.date', ['date' => $order->created_at->format('d/m/Y à H:i')]) }}</small><br>
                <small>{{ __('email.order.payment_method', ['method' => ucfirst($order->payment_method)]) }}</small>
            </div>
            
            <div class="section">
                <h3>{{ __('email.order.addresses') }}</h3>
                <div style="display: flex; gap: 20px;">
                    <div class="address-box" style="flex: 1;">
                        <strong>{{ __('email.order.billing') }}</strong><br>
                        {{ $order->full_name }}<br>
                        @if($order->billing_company){{ $order->billing_company }}<br>@endif
                        {{ $order->billing_address_1 }}<br>
                        @if($order->billing_address_2){{ $order->billing_address_2 }}<br>@endif
                        {{ $order->billing_postcode }} {{ $order->billing_city }}<br>
                        {{ $order->billing_country }}<br>
                        📞 {{ $order->billing_phone }}<br>
                        ✉️ {{ $order->billing_email }}
                    </div>
                    <div class="address-box" style="flex: 1;">
                        <strong>{{ __('email.order.shipping') }}</strong><br>
                        {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
                        {{ $order->shipping_address_1 }}<br>
                        {{ $order->shipping_postcode }} {{ $order->shipping_city }}<br>
                        {{ $order->shipping_country }}
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h3>{{ __('email.order.your_order') }}</h3>
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('email.order.product') }}</th>
                            <th>{{ __('email.order.price') }}</th>
                            <th>{{ __('email.order.quantity') }}</th>
                            <th>{{ __('email.order.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if(!empty($item['image']))
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; vertical-align: middle; margin-right: 10px;">
                                @endif
                                <strong>{{ $item['name'] }}</strong>
                            </td>
                            <td>{{ number_format($item['price'], 2, ',', ' ') }}€</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td class="amount">{{ number_format($item['price'] * $item['quantity'], 2, ',', ' ') }}€</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3"><strong>{{ __('email.order.total') }}</strong></td>
                            <td class="amount"><strong>{{ number_format($order->total, 2, ',', ' ') }}€</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="section">
                <h3>{{ __('email.order.payment_details') }}</h3>
                <p>
                    {{ __('email.order.subtotal') }} : {{ number_format($order->subtotal, 2, ',', ' ') }}€<br>
                    {{ __('email.order.shipping') }} : {{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2, ',', ' ') . '€' : __('email.order.free_shipping') }}<br>
                    @if($order->tax > 0){{ __('email.order.tax') }} : {{ number_format($order->tax, 2, ',', ' ') }}€<br>@endif
                    @if($order->coupon_code){{ __('email.order.coupon') }} : {{ $order->coupon_code }}<br>@endif
                    <strong>{{ __('email.order.total') }} : {{ number_format($order->total, 2, ',', ' ') }}€</strong>
                </p>
            </div>
            
            @if($order->notes)
            <div class="section">
                <h3>{{ __('email.order.notes') }}</h3>
                <p>{{ $order->notes }}</p>
            </div>
            @endif
       
            
            <p>{!! __('email.order.contact_support', ['email' => config('mail.support_email', 'support@example.com')]) !!}</p>
            <p>{{ __('email.order.goodbye') }}<br>{{ __('email.order.team', ['name' => config('app.name')]) }}</p>
        </div>
        
        <div class="footer">
            <p>{{ __('email.order.copyright', ['year' => date('Y'), 'name' => config('app.name')]) }}</p>
        </div>
    </div>
</body>
</html>