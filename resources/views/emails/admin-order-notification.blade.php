{{-- resources/views/emails/admin-order-notification.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; }
        .header { background: #e74c3c; color: white; padding: 25px; text-align: center; }
        .header h1 { margin: 0; font-size: 22px; }
        .badge { display: inline-block; background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px; margin-top: 10px; }
        .body { padding: 25px; }
        .alert { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 15px 0; }
        .order-number { font-size: 22px; color: #e74c3c; font-weight: bold; }
        .section { margin: 20px 0; }
        .section h3 { color: #e74c3c; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; }
        .info-grid { display: flex; gap: 15px; margin: 15px 0; }
        .info-card { flex: 1; background: #f9f9f9; padding: 15px; border-radius: 8px; }
        .info-card h4 { color: #e74c3c; margin: 0 0 10px; font-size: 13px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #f8f9fa; padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6; font-size: 13px; }
        td { padding: 10px; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .total-row { font-weight: bold; font-size: 18px; background: #fff8f0; }
        .total-row td { border-top: 2px solid #e74c3c; }
        .amount { color: #e74c3c; font-weight: bold; }
        .btn { display: inline-block; padding: 15px 40px; background: #e74c3c; color: white; text-decoration: none; border-radius: 25px; font-weight: bold; }
        .meta { font-size: 12px; color: #999; margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; }
        .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛎️ Nouvelle commande</h1>
            <div class="badge">À traiter</div>
        </div>
        
        <div class="body">
            <div class="alert">
                <strong>📢 Nouvelle commande reçue !</strong><br>
                <span class="order-number">#{{ $order->order_number }}</span><br>
                <strong>Total : {{ number_format($order->total, 2, ',', ' ') }}€</strong><br>
                <small>Date : {{ $order->created_at->format('d/m/Y à H:i') }}</small>
            </div>
            
            <div class="section">
                <h3>👤 Client</h3>
                <div class="info-grid">
                    <div class="info-card">
                        <h4>Informations</h4>
                        <strong>{{ $order->full_name }}</strong><br>
                        @if($order->billing_company){{ $order->billing_company }}<br>@endif
                        📞 {{ $order->billing_phone }}<br>
                        ✉️ {{ $order->billing_email }}
                    </div>
                    <div class="info-card">
                        <h4>Paiement</h4>
                        Méthode : {{ ucfirst($order->payment_method) }}<br>
                        Statut : {{ ucfirst($order->payment_status) }}<br>
                        Commande : {{ ucfirst($order->status) }}
                        @if($order->coupon_code)<br>Code promo : {{ $order->coupon_code }}@endif
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h3>📍 Adresses</h3>
                <div class="info-grid">
                    <div class="info-card">
                        <h4>Facturation</h4>
                        {{ $order->full_name }}<br>
                        @if($order->billing_company){{ $order->billing_company }}<br>@endif
                        {{ $order->billing_address_1 }}<br>
                        @if($order->billing_address_2){{ $order->billing_address_2 }}<br>@endif
                        {{ $order->billing_postcode }} {{ $order->billing_city }}<br>
                        {{ $order->billing_country }}
                    </div>
                    <div class="info-card">
                        <h4>Livraison</h4>
                        {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
                        {{ $order->shipping_address_1 }}<br>
                        {{ $order->shipping_postcode }} {{ $order->shipping_city }}<br>
                        {{ $order->shipping_country }}
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h3>📦 Produits commandés ({{ $order->items_count }})</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix unit.</th>
                            <th>Qté</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ number_format($item['price'], 2, ',', ' ') }}€</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td class="amount">{{ number_format($item['price'] * $item['quantity'], 2, ',', ' ') }}€</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3"><strong>TOTAL</strong></td>
                            <td class="amount"><strong>{{ number_format($order->total, 2, ',', ' ') }}€</strong></td>
                        </tr>
                    </tbody>
                </table>
                
                <table style="background: #f9f9f9;">
                    <tr>
                        <td>Sous-total</td>
                        <td class="amount">{{ number_format($order->subtotal, 2, ',', ' ') }}€</td>
                    </tr>
                    <tr>
                        <td>Livraison</td>
                        <td class="amount">{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2, ',', ' ') . '€' : 'Gratuite' }}</td>
                    </tr>
                    @if($order->tax > 0)
                    <tr>
                        <td>TVA</td>
                        <td class="amount">{{ number_format($order->tax, 2, ',', ' ') }}€</td>
                    </tr>
                    @endif
                </table>
            </div>
            
            @if($order->notes)
            <div class="section">
                <h3>📝 Notes client</h3>
                <p>{{ $order->notes }}</p>
            </div>
            @endif
            
            
            <div class="meta">
                <strong>IP :</strong> {{ $order->ip_address }}<br>
                <strong>Navigateur :</strong> {{ $order->user_agent }}
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }} - Notification automatique</p>
        </div>
    </div>
</body>
</html>