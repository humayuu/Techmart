@component('mail::message')
<div style="text-align:center;padding:10px 0 30px 0;">
<span style="font-size:36px;font-weight:900;letter-spacing:2px;color:#111;">TECH<span style="color:#6366f1;">MART</span></span>
<p style="margin:4px 0 0 0;font-size:11px;color:#888;letter-spacing:3px;">YOUR TECH DESTINATION</p>
</div>

## Order Confirmed! 🎉

Dear {{ $order->user->name }},

Thank you for shopping with us. Your order has been placed successfully.

<table style="width:100%;border-collapse:collapse;margin:20px 0;background:#f8f8f8;border-radius:6px;">
<tr>
<td style="padding:10px 15px;font-weight:bold;width:40%;">Order ID</td>
<td style="padding:10px 15px;">#{{ $order->id }}</td>
</tr>
<tr>
<td style="padding:10px 15px;font-weight:bold;">Date</td>
<td style="padding:10px 15px;">{{ $order->created_at->format('d M Y') }}</td>
</tr>
<tr>
<td style="padding:10px 15px;font-weight:bold;">Payment</td>
<td style="padding:10px 15px;">{{ strtoupper($order->payment_method) }}</td>
</tr>
<tr>
<td style="padding:10px 15px;font-weight:bold;">Status</td>
<td style="padding:10px 15px;">{{ ucfirst($order->payment_status) }}</td>
</tr>
</table>

## 🛍️ Order Items

@component('mail::table')
| Product | Qty | Price |
|:--------|:---:|------:|
@foreach ($order->orderProducts as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | Rs. {{ number_format($item->sub_total, 2) }} |
@endforeach
@endcomponent

<table style="width:100%;border-collapse:collapse;margin:20px 0;background:#f8f8f8;">
<tr>
<td style="padding:10px 15px;">Subtotal</td>
<td style="padding:10px 15px;text-align:right;">Rs. {{ number_format($order->subtotal, 2) }}</td>
</tr>
<tr>
<td style="padding:10px 15px;">Shipping</td>
<td style="padding:10px 15px;text-align:right;">Rs. {{ number_format($order->shipping_amount, 2) }}</td>
</tr>
<tr style="font-weight:bold;border-top:2px solid #ddd;">
<td style="padding:10px 15px;">Total</td>
<td style="padding:10px 15px;text-align:right;">Rs. {{ number_format($order->total_amount, 2) }}</td>
</tr>
</table>

📦 **Shipping Address**

{{ $order->address }}, {{ $order->city }}, {{ $order->province }} {{ $order->zip }}

@component('mail::button', ['url' => url('/'), 'color' => 'success'])
Continue Shopping
@endcomponent

<p style="text-align:center;font-size:12px;color:#aaa;margin-top:30px;">
© {{ date('Y') }} TechMart. All rights reserved.
</p>

Thanks,
**TechMart Team**
@endcomponent
