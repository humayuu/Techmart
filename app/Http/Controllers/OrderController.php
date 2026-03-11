<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * For Pending Orders
     */
    public function pendingOrders(Request $request)
    {
        $totalPending = Order::where('status', 'pending')->count();

        if ($request->ajax()) {

            $pendingOrders = Order::with('user')
                ->where('status', 'pending')
                ->latest();

            return DataTables::of($pendingOrders)
                ->addIndexColumn()

                ->addColumn('customer', function ($order) {
                    return $order->user->name.'<br>
                        <small class="text-muted">'.$order->user->email.'</small>';
                })
                ->addColumn('order_id', function ($order) {
                    return '#'.$order->id;
                })
                ->addColumn('city', function ($order) {
                    return $order->city;
                })

                ->addColumn('payment', function ($order) {
                    $method = $order->payment_method === 'cod'
                        ? '<span class="badge bg-warning text-dark">COD</span>'
                        : '<span class="badge bg-primary">Stripe</span>';

                    $status = match ($order->payment_status) {
                        'paid' => '<span class="badge bg-success">Paid</span>',
                        'refunded' => '<span class="badge bg-secondary">Refunded</span>',
                        default => '<span class="badge bg-warning text-dark">Pending</span>',
                    };

                    return $method.'<br><small>'.$status.'</small>';
                })

                ->addColumn('total', function ($order) {
                    return '<strong>RS.'.number_format($order->total_amount, 2).'</strong>';
                })

                ->addColumn('date', function ($order) {
                    return $order->created_at->format('M d, Y').'<br>
                        <small class="text-muted">'.$order->created_at->format('h:i A').'</small>';
                })

                ->addColumn('status', function ($order) {
                    $badge = match ($order->status) {
                        'pending' => 'bg-warning text-dark fs-6',
                        'processing' => 'bg-info text-dark fs-6',
                        'shipped' => 'bg-primary fs-6',
                        'delivered' => 'bg-success fs-6',
                        'cancelled' => 'bg-danger fs-6',
                        'refunded' => 'bg-secondary fs-6',
                        default => 'bg-secondary fs-6',
                    };

                    return '<span class="badge '.$badge.'">'.ucfirst($order->status).'</span>';
                })

                ->addColumn('action', function ($order) {
                    $showUrl = route('orders.detail', $order->id);
                    $updateUrl = route('admin.orders.updateStatus', $order->id);
                    // $updateUrl = route('admin.orders.update', $order->id);

                    $btn = '
                <a href="'.$showUrl.'" class="btn btn-sm btn-dark mb-1">
                    <i class="fas fa-eye"></i>
                </a>

                <form action="'.$updateUrl.'" method="POST" class="d-inline" id="form-'.$order->id.'">
    '.csrf_field().method_field('PUT').'
    <input type="hidden" name="status" id="status-'.$order->id.'">

    <div class="btn-group ms-1">
        <button type="button"
                class="btn btn-sm btn-warning dropdown-toggle"
                data-bs-toggle="dropdown"
                data-bs-boundary="viewport">
            '.ucfirst($order->status).'
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'pending\')">
                <span class="badge bg-warning text-dark me-1">●</span> Pending
            </a></li>
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'processing\')">
                <span class="badge bg-info text-dark me-1">●</span> Processing
            </a></li>
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'shipped\')">
                <span class="badge bg-primary me-1">●</span> Shipped
            </a></li>
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'delivered\')">
                <span class="badge bg-success me-1">●</span> Delivered
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'cancelled\')">
                <span class="badge bg-danger me-1">●</span> Cancelled
            </a></li>
        </ul>
    </div>
</form>';

                    return $btn;
                })

                ->rawColumns(['order_id', 'customer', 'payment', 'total', 'date', 'status', 'action'])->make(true);
        }

        return view('admin.order.pending', compact('totalPending'));
    }

    /**
     * For Order Detail page
     */
    public function OrderDetail($id)
    {
        $order = Order::findOrFail($id);

        $orderProducts = OrderProduct::where('order_id', $id)->get();

        return view('admin.order.order-detail', compact('order', 'orderProducts'));
    }

    /**
     * For Change Order Status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    /**
     * For Processing Order
     */
    public function ProcessingOrders(Request $request)
    {
        $totalProcessing = Order::where('status', 'processing')->count();

        if ($request->ajax()) {

            $processingOrders = Order::with('user')
                ->where('status', 'processing')
                ->latest();

            return DataTables::of($processingOrders)
                ->addIndexColumn()

                ->addColumn('customer', function ($order) {
                    return $order->user->name.'<br>
                        <small class="text-muted">'.$order->user->email.'</small>';
                })
                ->addColumn('order_id', function ($order) {
                    return '#'.$order->id;
                })
                ->addColumn('city', function ($order) {
                    return $order->city;
                })

                ->addColumn('payment', function ($order) {
                    $method = $order->payment_method === 'cod'
                        ? '<span class="badge bg-warning text-dark">COD</span>'
                        : '<span class="badge bg-primary">Stripe</span>';

                    $status = match ($order->payment_status) {
                        'paid' => '<span class="badge bg-success">Paid</span>',
                        'refunded' => '<span class="badge bg-secondary">Refunded</span>',
                        default => '<span class="badge bg-warning text-dark">Pending</span>',
                    };

                    return $method.'<br><small>'.$status.'</small>';
                })

                ->addColumn('total', function ($order) {
                    return '<strong>RS.'.number_format($order->total_amount, 2).'</strong>';
                })

                ->addColumn('date', function ($order) {
                    return $order->created_at->format('M d, Y').'<br>
                        <small class="text-muted">'.$order->created_at->format('h:i A').'</small>';
                })

                ->addColumn('status', function ($order) {
                    $badge = match ($order->status) {
                        'pending' => 'bg-warning text-dark fs-6',
                        'processing' => 'bg-info text-dark fs-6',
                        'shipped' => 'bg-primary fs-6',
                        'delivered' => 'bg-success fs-6',
                        'cancelled' => 'bg-danger fs-6',
                        'refunded' => 'bg-secondary fs-6',
                        default => 'bg-secondary fs-6',
                    };

                    return '<span class="badge '.$badge.'">'.ucfirst($order->status).'</span>';
                })

                ->addColumn('action', function ($order) {
                    $showUrl = route('orders.detail', $order->id);
                    $updateUrl = route('admin.orders.updateStatus', $order->id);

                    $btn = '
                <a href="'.$showUrl.'" class="btn btn-sm btn-dark mb-1">
                    <i class="fas fa-eye"></i>
                </a>

                <form action="'.$updateUrl.'" method="POST" class="d-inline" id="form-'.$order->id.'">
    '.csrf_field().method_field('PUT').'
    <input type="hidden" name="status" id="status-'.$order->id.'">

    <div class="btn-group ms-1">
        <button type="button"
                class="btn btn-sm btn-warning dropdown-toggle"
                data-bs-toggle="dropdown"
                data-bs-boundary="viewport">
            '.ucfirst($order->status).'
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'shipped\')">
                <span class="badge bg-primary me-1">●</span> Shipped
            </a></li>
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'delivered\')">
                <span class="badge bg-success me-1">●</span> Delivered
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'cancelled\')">
                <span class="badge bg-danger me-1">●</span> Cancelled
            </a></li>

        </ul>
    </div>
</form>';

                    return $btn;
                })

                ->rawColumns(['order_id', 'customer', 'payment', 'total', 'date', 'status', 'action'])->make(true);
        }

        return view('admin.order.processing', compact('totalProcessing'));
    }

    /**
     * For Shipped Orders
     */
    public function ShippedOrders(Request $request)
    {
        $totalShipped = Order::where('status', 'shipped')->count();

        if ($request->ajax()) {

            $shippedOrders = Order::with('user')
                ->where('status', 'shipped')
                ->latest();

            return DataTables::of($shippedOrders)
                ->addIndexColumn()

                ->addColumn('customer', function ($order) {
                    return $order->user->name.'<br>
                        <small class="text-muted">'.$order->user->email.'</small>';
                })
                ->addColumn('order_id', function ($order) {
                    return '#'.$order->id;
                })
                ->addColumn('city', function ($order) {
                    return $order->city;
                })

                ->addColumn('payment', function ($order) {
                    $method = $order->payment_method === 'cod'
                        ? '<span class="badge bg-warning text-dark">COD</span>'
                        : '<span class="badge bg-primary">Stripe</span>';

                    $status = match ($order->payment_status) {
                        'paid' => '<span class="badge bg-success">Paid</span>',
                        'refunded' => '<span class="badge bg-secondary">Refunded</span>',
                        default => '<span class="badge bg-warning text-dark">Pending</span>',
                    };

                    return $method.'<br><small>'.$status.'</small>';
                })

                ->addColumn('total', function ($order) {
                    return '<strong>RS.'.number_format($order->total_amount, 2).'</strong>';
                })

                ->addColumn('date', function ($order) {
                    return $order->created_at->format('M d, Y').'<br>
                        <small class="text-muted">'.$order->created_at->format('h:i A').'</small>';
                })

                ->addColumn('status', function ($order) {
                    $badge = match ($order->status) {
                        'pending' => 'bg-warning text-dark fs-6',
                        'processing' => 'bg-info text-dark fs-6',
                        'shipped' => 'bg-primary fs-6',
                        'delivered' => 'bg-success fs-6',
                        'cancelled' => 'bg-danger fs-6',
                        'refunded' => 'bg-secondary fs-6',
                        default => 'bg-secondary fs-6',
                    };

                    return '<span class="badge '.$badge.'">'.ucfirst($order->status).'</span>';
                })

                ->addColumn('action', function ($order) {
                    $showUrl = route('orders.detail', $order->id);
                    $updateUrl = route('admin.orders.updateStatus', $order->id);

                    $btn = '
                <a href="'.$showUrl.'" class="btn btn-sm btn-dark mb-1">
                    <i class="fas fa-eye"></i>
                </a>

                <form action="'.$updateUrl.'" method="POST" class="d-inline" id="form-'.$order->id.'">
    '.csrf_field().method_field('PUT').'
    <input type="hidden" name="status" id="status-'.$order->id.'">

    <div class="btn-group ms-1">
        <button type="button"
                class="btn btn-sm btn-warning dropdown-toggle"
                data-bs-toggle="dropdown"
                data-bs-boundary="viewport">
            '.ucfirst($order->status).'
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'delivered\')">
                <span class="badge bg-success me-1">●</span> Delivered
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'cancelled\')">
                <span class="badge bg-danger me-1">●</span> Cancelled
            </a></li>
        </ul>
    </div>
</form>';

                    return $btn;
                })

                ->rawColumns(['order_id', 'customer', 'payment', 'total', 'date', 'status', 'action'])->make(true);
        }

        return view('admin.order.shipped', compact('totalShipped'));
    }

    /**
     * For Delivered
     */
    public function Delivered(Request $request)
    {
        $totalDelivered = Order::where('status', 'delivered')->count();

        if ($request->ajax()) {

            $delivered = Order::with('user')
                ->where('status', 'delivered')
                ->latest();

            return DataTables::of($delivered)
                ->addIndexColumn()

                ->addColumn('customer', function ($order) {
                    return $order->user->name.'<br>
                        <small class="text-muted">'.$order->user->email.'</small>';
                })
                ->addColumn('order_id', function ($order) {
                    return '#'.$order->id;
                })
                ->addColumn('city', function ($order) {
                    return $order->city;
                })

                ->addColumn('payment', function ($order) {
                    $method = $order->payment_method === 'cod'
                        ? '<span class="badge bg-warning text-dark">COD</span>'
                        : '<span class="badge bg-primary">Stripe</span>';

                    $status = match ($order->payment_status) {
                        'paid' => '<span class="badge bg-success">Paid</span>',
                        'refunded' => '<span class="badge bg-secondary">Refunded</span>',
                        default => '<span class="badge bg-warning text-dark">Pending</span>',
                    };

                    return $method.'<br><small>'.$status.'</small>';
                })

                ->addColumn('total', function ($order) {
                    return '<strong>RS.'.number_format($order->total_amount, 2).'</strong>';
                })

                ->addColumn('date', function ($order) {
                    return $order->created_at->format('M d, Y').'<br>
                        <small class="text-muted">'.$order->created_at->format('h:i A').'</small>';
                })

                ->addColumn('status', function ($order) {
                    $badge = match ($order->status) {
                        'pending' => 'bg-warning text-dark fs-6',
                        'processing' => 'bg-info text-dark fs-6',
                        'shipped' => 'bg-primary fs-6',
                        'delivered' => 'bg-success fs-6',
                        'cancelled' => 'bg-danger fs-6',
                        'refunded' => 'bg-secondary fs-6',
                        default => 'bg-secondary fs-6',
                    };

                    return '<span class="badge '.$badge.'">'.ucfirst($order->status).'</span>';
                })

                ->addColumn('action', function ($order) {
                    $invoice = route('invoice.pdf', $order->id);

                    $btn = '
                <a href="'.$invoice.'" class="btn btn-sm btn-dark mb-1 ">
                    <i class="fa-solid fa-file-lines"></i>
                </a>';

                    return $btn;
                })

                ->rawColumns(['order_id', 'customer', 'payment', 'total', 'date', 'status', 'action'])->make(true);
        }

        return view('admin.order.delivered', compact('totalDelivered'));
    }

    /**
     * For Cancel Orders
     */
    public function CancelOrder(Request $request)
    {
        $totalCancelOrders = Order::where('status', 'cancelled')->count();

        if ($request->ajax()) {

            $cancelOrder = Order::with('user')
                ->where('status', 'cancelled')
                ->latest();

            return DataTables::of($cancelOrder)
                ->addIndexColumn()

                ->addColumn('customer', function ($order) {
                    return $order->user->name.'<br>
                        <small class="text-muted">'.$order->user->email.'</small>';
                })
                ->addColumn('order_id', function ($order) {
                    return '#'.$order->id;
                })
                ->addColumn('city', function ($order) {
                    return $order->city;
                })

                ->addColumn('payment', function ($order) {
                    $method = $order->payment_method === 'cod'
                        ? '<span class="badge bg-warning text-dark">COD</span>'
                        : '<span class="badge bg-primary">Stripe</span>';

                    $status = match ($order->payment_status) {
                        'paid' => '<span class="badge bg-success">Paid</span>',
                        'refunded' => '<span class="badge bg-secondary">Refunded</span>',
                        default => '<span class="badge bg-warning text-dark">Pending</span>',
                    };

                    return $method.'<br><small>'.$status.'</small>';
                })

                ->addColumn('total', function ($order) {
                    return '<strong>RS.'.number_format($order->total_amount, 2).'</strong>';
                })

                ->addColumn('date', function ($order) {
                    return $order->created_at->format('M d, Y').'<br>
                        <small class="text-muted">'.$order->created_at->format('h:i A').'</small>';
                })

                ->addColumn('status', function ($order) {
                    $badge = match ($order->status) {
                        'pending' => 'bg-warning text-dark fs-6',
                        'processing' => 'bg-info text-dark fs-6',
                        'shipped' => 'bg-primary fs-6',
                        'delivered' => 'bg-success fs-6',
                        'cancelled' => 'bg-danger fs-6',
                        'refunded' => 'bg-secondary fs-6',
                        default => 'bg-secondary fs-6',
                    };

                    return '<span class="badge '.$badge.'">'.ucfirst($order->status).'</span>';
                })
                ->addColumn('action', function ($order) {
                    $showUrl = route('orders.detail', $order->id);
                    $updateUrl = route('admin.orders.updateStatus', $order->id);

                    $btn = '
                <a href="'.$showUrl.'" class="btn btn-sm btn-dark mb-1">
                    <i class="fas fa-eye"></i>
                </a>

                <form action="'.$updateUrl.'" method="POST" class="d-inline" id="form-'.$order->id.'">
    '.csrf_field().method_field('PUT').'
    <input type="hidden" name="status" id="status-'.$order->id.'">

    <div class="btn-group ms-1">
        <button type="button"
                class="btn btn-sm btn-warning dropdown-toggle"
                data-bs-toggle="dropdown"
                data-bs-boundary="viewport">
            '.ucfirst($order->status).'
        </button>
        <ul class="dropdown-menu">
         <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'refunded\')">
                <span class="badge bg-secondary me-1">●</span> Refunded
            </a></li>
        </ul>
    </div>
</form>';

                    return $btn;
                })

                ->rawColumns(['order_id', 'customer', 'payment', 'total', 'date', 'status', 'action'])->make(true);
        }

        return view('admin.order.cancelled', compact('totalCancelOrders'));
    }

    /**
     * For Refunded
     */
    public function Refunded(Request $request)
    {
        $totalRefundOrders = Order::where('status', 'refunded')->count();

        if ($request->ajax()) {

            $refunded = Order::with('user')
                ->where('status', 'refunded')
                ->latest();

            return DataTables::of($refunded)
                ->addIndexColumn()

                ->addColumn('customer', function ($order) {
                    return $order->user->name.'<br>
                        <small class="text-muted">'.$order->user->email.'</small>';
                })
                ->addColumn('order_id', function ($order) {
                    return '#'.$order->id;
                })
                ->addColumn('city', function ($order) {
                    return $order->city;
                })

                ->addColumn('payment', function ($order) {
                    $method = $order->payment_method === 'cod'
                        ? '<span class="badge bg-warning text-dark">COD</span>'
                        : '<span class="badge bg-primary">Stripe</span>';

                    $status = match ($order->payment_status) {
                        'paid' => '<span class="badge bg-success">Paid</span>',
                        'refunded' => '<span class="badge bg-secondary">Refunded</span>',
                        default => '<span class="badge bg-warning text-dark">Pending</span>',
                    };

                    return $method.'<br><small>'.$status.'</small>';
                })

                ->addColumn('total', function ($order) {
                    return '<strong>RS.'.number_format($order->total_amount, 2).'</strong>';
                })

                ->addColumn('date', function ($order) {
                    return $order->created_at->format('M d, Y').'<br>
                        <small class="text-muted">'.$order->created_at->format('h:i A').'</small>';
                })

                ->addColumn('status', function ($order) {
                    $badge = match ($order->status) {
                        'pending' => 'bg-warning text-dark fs-6',
                        'processing' => 'bg-info text-dark fs-6',
                        'shipped' => 'bg-primary fs-6',
                        'delivered' => 'bg-success fs-6',
                        'cancelled' => 'bg-danger fs-6',
                        'refunded' => 'bg-secondary fs-6',
                        default => 'bg-secondary fs-6',
                    };

                    return '<span class="badge '.$badge.'">'.ucfirst($order->status).'</span>';
                })
                ->addColumn('action', function ($order) {
                    $showUrl = route('orders.detail', $order->id);
                    $updateUrl = route('admin.orders.updateStatus', $order->id);

                    $btn = '
                <a href="'.$showUrl.'" class="btn btn-sm btn-dark mb-1">
                    <i class="fas fa-eye"></i>
                </a>

                <form action="'.$updateUrl.'" method="POST" class="d-inline" id="form-'.$order->id.'">
    '.csrf_field().method_field('PUT').'
    <input type="hidden" name="status" id="status-'.$order->id.'">

    <div class="btn-group ms-1">
        <button type="button"
                class="btn btn-sm btn-warning dropdown-toggle"
                data-bs-toggle="dropdown"
                data-bs-boundary="viewport">
            '.ucfirst($order->status).'
        </button>
        <ul class="dropdown-menu">
         <li><a class="dropdown-item" href="#"
                onclick="updateStatus('.$order->id.', \'refunded\')">
                <span class="badge bg-secondary me-1">●</span> Refunded
            </a></li>
        </ul>
    </div>
</form>';

                    return $btn;
                })

                ->rawColumns(['order_id', 'customer', 'payment', 'total', 'date', 'status', 'action'])->make(true);
        }

        return view('admin.order.refunded', compact('totalRefundOrders'));
    }

    /**
     * For Invoice Pdf
     */
    public function InvoicePdf($id)
    {
        $order = Order::with(['user', 'orderProducts.product'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.order.invoice-pdf', [
            'invoice_id' => $order->id,
            'date' => $order->created_at->format('d M Y'),
            'customer_name' => $order->user->name,
            'customer_email' => $order->user->email,
            'address' => $order->address,
            'city' => $order->city,
            'province' => $order->province,
            'payment_method' => $order->payment_method,
            'payment_status' => $order->payment_status,
            'subtotal' => $order->subtotal,
            'shipping' => $order->shipping_amount,
            'discount' => $order->discount_amount,
            'total' => $order->total_amount,
            'items' => $order->orderProducts,
        ]);

        return $pdf->stream('invoice_'.$order->id.'.pdf');
    }
}
