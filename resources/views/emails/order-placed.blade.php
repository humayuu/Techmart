@component('mail::message')
<div style="max-width:560px;margin:0 auto;background:#fff;border-top:3px solid #111;">

<div style="padding:35px 40px 25px;border-bottom:1px solid #eee;">
<p style="margin:0;font-size:22px;font-weight:700;letter-spacing:2px;color:#111;">TECHMART</p>
<p style="margin:4px 0 0;font-size:11px;color:#999;letter-spacing:2px;">ORDER CONFIRMATION</p>
</div>

<div style="padding:35px 40px;">

<p style="font-size:15px;color:#111;margin:0 0 6px;">Hello, <strong>{{ $order->user->name }}</strong></p>
<p style="font-size:13px;color:#777;margin:0 0 30px;line-height:1.7;">Your order has been placed successfully. Here's a summary of what you ordered.</p>

<table style="width:100%;border-collapse:collapse;margin-bottom:30px;">
<tr>
<td style="padding:9px 0;font-size:12px;color:#999;border-bottom:1px solid #f0f0f0;width:40%;">Order ID</td>
<td style="padding:9px 0;font-size:13px;color:#111;border-bottom:1px solid #f0f0f0;font-weight:600;">#{{ $order->id }}</td>
</tr>
<tr>
<td style="padding:9px 0;font-size:12px;color:#999;border-bottom:1px solid #f0f0f0;">Date</td>
<td style="padding:9px 0;font-size:13px;color:#111;border-bottom:1px solid #f0f0f0;">{{ $order->created_at->format('d M Y') }}</td>
</tr>
<tr>
<td style="padding:9px 0;font-size:12px;color:#999;border-bottom:1px solid #f0f0f0;">Payment</td>
<td style="padding:9px 0;font-size:13px;color:#111;border-bottom:1px solid #f0f0f0;">{{ strtoupper($order->payment_method) }}</td>
</tr>
<tr>
<td style="padding:9px 0;font-size:12px;color:#999;">Status</td>
<td style="padding:9px 0;font-size:12px;">
@if($order->payment_status === 'paid')
<span style="background:#f0fdf4;color:#16a34a;padding:2px 10px;border-radius:3px;font-weight:600;">Paid</span>
@else
<span style="background:#fefce8;color:#ca8a04;padding:2px 10px;border-radius:3px;font-weight:600;">Pending</span>
@endif
</td>
</tr>
</table>

<p style="font-size:11px;letter-spacing:2px;color:#bbb;margin:0 0 15px;">ITEMS ORDERED</p>

<table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
@foreach ($order->orderProducts as $item)
<tr style="border-bottom:1px solid #f0f0f0;">
<td style="padding:10px 0;font-size:13px;color:#111;">{{ $item->product_name }}</td>
<td style="padding:10px 0;font-size:13px;color:#999;text-align:center;">x{{ $item->quantity }}</td>
<td style="padding:10px 0;font-size:13px;color:#111;text-align:right;">Rs. {{ number_format($item->sub_total, 2) }}</td>
</tr>
@endforeach
</table>

<table style="width:100%;border-collapse:collapse;margin-bottom:30px;">
<tr>
<td style="padding:6px 0;font-size:12px;color:#999;">Subtotal</td>
<td style="padding:6px 0;font-size:12px;color:#777;text-align:right;">Rs. {{ number_format($order->subtotal, 2) }}</td>
</tr>
<tr>
<td style="padding:6px 0;font-size:12px;color:#999;">Shipping ({{ ucfirst($order->shipping_method) }})</td>
<td style="padding:6px 0;font-size:12px;color:#777;text-align:right;">Rs. {{ number_format($order->shipping_amount, 2) }}</td>
</tr>
<tr style="border-top:1px solid #111;">
<td style="padding:10px 0 0;font-size:14px;color:#111;font-weight:700;">Total</td>
<td style="padding:10px 0 0;font-size:14px;color:#111;font-weight:700;text-align:right;">Rs. {{ number_format($order->total_amount, 2) }}</td>
</tr>
</table>

<p style="font-size:11px;letter-spacing:2px;color:#bbb;margin:0 0 10px;">SHIPPING TO</p>
<p style="font-size:13px;color:#555;line-height:1.8;margin:0 0 35px;">
{{ $order->address }}<br>
{{ $order->city }}, {{ $order->province }} — {{ $order->zip }}
</p>

</div>

<div style="padding:20px 40px;border-top:1px solid #eee;text-align:center;">
<p style="font-size:11px;color:#bbb;margin:0;">© {{ date('Y') }} TechMart &nbsp;·&nbsp; All rights reserved</p>
</div>

</div>
@endcomponent
