<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    // PRIVATE HELPERS

    private function applySharedColumns($datatable)
    {
        return $datatable
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
            });
    }

    private function buildActionColumn($datatable, array $statusOptions, bool $showView = true)
    {
        return $datatable->addColumn('action', function ($order) use ($statusOptions, $showView) {

            $updateUrl = route('admin.orders.updateStatus', $order->id);
            $btn = '';

            if ($showView) {
                $showUrl = route('orders.detail', $order->id);
                $btn .= '<a href="'.$showUrl.'" class="btn btn-sm btn-dark mb-1">
                            <i class="fas fa-eye"></i>
                         </a>';
            }

            $btn .= '
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
                    <ul class="dropdown-menu">';

            foreach ($statusOptions as $value => $label) {
                $badge = $this->getStatusBadgeClass($value);
                $btn .= '<li>
                            <a class="dropdown-item" href="#"
                                onclick="updateStatus('.$order->id.', \''.$value.'\')">
                                <span class="badge '.$badge.' me-1">●</span> '.$label.'
                            </a>
                         </li>';
            }

            $btn .= '   </ul>
                </div>
            </form>';

            return $btn;
        });
    }

    private function getStatusBadgeClass(string $status): string
    {
        return match ($status) {
            'pending' => 'bg-warning text-dark',
            'processing' => 'bg-info text-dark',
            'shipped' => 'bg-primary',
            'delivered' => 'bg-success',
            'cancelled' => 'bg-danger',
            'refunded' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }

    // shared rawColumns list
    private function rawCols(): array
    {
        return ['order_id', 'customer', 'payment', 'total', 'date', 'status', 'action'];
    }

    // PUBLIC METHODS

    public function pendingOrders(Request $request)
    {
        $totalPending = Order::where('status', 'pending')->count();

        if ($request->ajax()) {
            $query = Order::with('user')->where('status', 'pending')->latest();
            $datatable = $this->applySharedColumns(DataTables::of($query));
            $datatable = $this->buildActionColumn($datatable, [
                'processing' => 'Processing',
                'cancelled' => 'Cancelled',
            ]);

            return $datatable->rawColumns($this->rawCols())->make(true);
        }

        return view('admin.order.pending', compact('totalPending'));
    }

    public function processingOrders(Request $request)
    {
        $totalProcessing = Order::where('status', 'processing')->count();

        if ($request->ajax()) {
            $query = Order::with('user')->where('status', 'processing')->latest();
            $datatable = $this->applySharedColumns(DataTables::of($query));
            $datatable = $this->buildActionColumn($datatable, [
                'shipped' => 'Shipped',
                'cancelled' => 'Cancelled',
            ]);

            return $datatable->rawColumns($this->rawCols())->make(true);
        }

        return view('admin.order.processing', compact('totalProcessing'));
    }

    public function shippedOrders(Request $request)
    {
        $totalShipped = Order::where('status', 'shipped')->count();

        if ($request->ajax()) {
            $query = Order::with('user')->where('status', 'shipped')->latest();
            $datatable = $this->applySharedColumns(DataTables::of($query));
            $datatable = $this->buildActionColumn($datatable, [
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled',
            ]);

            return $datatable->rawColumns($this->rawCols())->make(true);
        }

        return view('admin.order.shipped', compact('totalShipped'));
    }

    public function delivered(Request $request)
    {
        $totalDelivered = Order::where('status', 'delivered')->count();

        if ($request->ajax()) {
            $query = Order::with('user')->where('status', 'delivered')->latest();
            $datatable = $this->applySharedColumns(DataTables::of($query));

            // delivered only gets invoice button — no status dropdown needed
            $datatable->addColumn('action', function ($order) {
                $invoice = route('invoice.pdf', $order->id);

                return '<a href="'.$invoice.'" class="btn btn-sm btn-dark mb-1">
                            <i class="fa-solid fa-file-lines"></i>
                        </a>';
            });

            return $datatable->rawColumns($this->rawCols())->make(true);
        }

        return view('admin.order.delivered', compact('totalDelivered'));
    }

    public function cancelOrder(Request $request)
    {
        $totalCancelOrders = Order::where('status', 'cancelled')->count();

        if ($request->ajax()) {
            $query = Order::with('user')->where('status', 'cancelled')->latest();
            $datatable = $this->applySharedColumns(DataTables::of($query));
            $datatable = $this->buildActionColumn($datatable, [
                'refunded' => 'Refunded',
            ]);

            $datatable->addColumn('action', function ($order) {
                $showUrl = route('orders.detail', $order->id);
                $deleteUrl = route('orders.delete', $order->id);

                return '
                <a href="'.$showUrl.'" class="btn btn-sm btn-dark mb-1">
                    <i class="fas fa-eye"></i>
                </a>
                <form action="'.$deleteUrl.'" method="POST" class="d-inline">
                    '.csrf_field().method_field('DELETE').'
                    <button id="delete" type="submit" class="btn btn-sm btn-danger mb-1">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>';
            });

            return $datatable->rawColumns($this->rawCols())->make(true);
        }

        return view('admin.order.cancelled', compact('totalCancelOrders'));
    }

    public function refunded(Request $request)
    {
        $totalRefundOrders = Order::where('status', 'refunded')->count();

        if ($request->ajax()) {
            $query = Order::with('user')->where('status', 'refunded')->latest();
            $datatable = $this->applySharedColumns(DataTables::of($query));

            // refunded is final state — view button only, no dropdown
            $datatable->addColumn('action', function ($order) {
                $showUrl = route('orders.detail', $order->id);

                return '<a href="'.$showUrl.'" class="btn btn-sm btn-dark mb-1">
                            <i class="fas fa-eye"></i>
                        </a>';
            });

            return $datatable->rawColumns($this->rawCols())->make(true);
        }

        return view('admin.order.refunded', compact('totalRefundOrders'));
    }

    public function orderDetail($id)
    {
        $order = Order::with('orderProducts')->findOrFail($id);

        return view('admin.order.order-detail', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        if ($request->status === 'delivered') {
            $order->update(['payment_status' => 'paid']);
        }

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function invoicePdf($id)
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

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'cancelled') {
            return redirect()->back()->with([
                'message' => 'Only cancelled orders can be deleted!',
                'alert-type' => 'error',
            ]);
        }

        $order->delete();

        return redirect()->back()->with([
            'message' => 'Order deleted successfully!',
            'alert-type' => 'success',
        ]);
    }
}
