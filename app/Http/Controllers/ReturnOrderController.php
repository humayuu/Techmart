<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReturnOrderController extends Controller
{
    public function index(Request $request)
    {
        $totalReturnOrders = ReturnOrder::count();

        if ($request->ajax()) {
            $query = ReturnOrder::with(['order', 'user'])->latest();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('order_id', function ($row) {
                    return '#'.$row->order->id;
                })
                ->addColumn('customer', function ($row) {
                    return $row->user->name.'<br>
                        <small class="text-muted">'.$row->user->email.'</small>';
                })
                ->addColumn('city', function ($row) {
                    return $row->order->city;
                })
                ->addColumn('payment', function ($row) {
                    return $row->order->payment_method === 'cod'
                        ? '<span class="badge bg-warning text-dark fs-6">COD</span>'
                        : '<span class="badge bg-primary fs-6">Stripe</span>';
                })
                ->addColumn('total', function ($row) {
                    return '<strong>Rs.'.number_format($row->refund_amount, 2).'</strong>';
                })
                ->addColumn('date', function ($row) {
                    return $row->created_at->format('M d, Y').'<br>
                        <small class="text-muted">'.$row->created_at->format('h:i A').'</small>';
                })
                ->addColumn('status', function ($row) {
                    $badge = match ($row->status) {
                        'pending' => 'bg-warning text-dark',
                        'refunded' => 'bg-success',
                        default => 'bg-secondary',
                    };

                    return '<span class="badge '.$badge.' fs-6">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('action', function ($row) {
                    $showUrl = route('return.show', $row->id);

                    // View button — always visible
                    $btn = '<a href="'.$showUrl.'" class="btn btn-sm btn-dark me-1" title="View">
                <i class="fas fa-eye"></i>
            </a>';

                    // Refund button — only for pending
                    if ($row->status === 'pending') {
                        $updateUrl = route('return.update', $row->id);
                        $btn .= '
                               <form action="'.$updateUrl.'" method="POST" class="d-inline">
                             '.csrf_field().method_field('PATCH').'
                             <input type="hidden" name="status" value="refunded">
                                <button type="submit" class="btn btn-sm btn-success me-1"
                                 title="Mark as Refunded" id="updateStatus" >
                              <i class="fas fa-check"></i>
                           </button>
                          </form>';
                    }

                    // Delete button — only for refunded, with inline form
                    if ($row->status === 'refunded') {
                        $deleteUrl = route('return.destroy', $row->id);
                        $btn .= '
                            <form action="'.$deleteUrl.'" method="POST" class="d-inline">
                               '.csrf_field().method_field('DELETE').'
                               <button type="submit" class="btn btn-sm btn-danger" title="Delete" id="delete" >
                                   <i class="fas fa-trash"></i>
                               </button>
                              </form>';
                    }

                    return $btn;
                })
                ->rawColumns(['order_id', 'customer', 'payment', 'total', 'date', 'status', 'action'])
                ->make(true);
        }

        return view('admin.return-order.index', compact('totalReturnOrders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'description' => 'required',
        ]);

        $order = Order::findOrFail($request->order_id);

        try {
            ReturnOrder::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'reason' => $request->reason,
                'description' => $request->description,
                'refund_amount' => $order->subtotal,
            ]);

            $order->update(['status' => 'return_request']);

            return redirect()->route('profile.edit')
                ->with('success', 'Return Request Submitted Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to Submit Return Request: '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $returnOrder = ReturnOrder::with(['order.orderProducts.product', 'user'])
            ->findOrFail($id);

        return view('admin.return-order.show', compact('returnOrder'));
    }

    public function update(Request $request, $id)
    {
        $returnOrder = ReturnOrder::findOrFail($id);

        $returnOrder->update([
            'status' => 'refunded',
            'refunded_at' => now(),
        ]);

        // Sync parent order status
        $returnOrder->order->update([
            'status' => 'refunded',
            'payment_status' => 'refunded',
        ]);

        return redirect()->back()->with([
            'message' => 'Order marked as refunded successfully.',
            'alert-type' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $returnOrder = ReturnOrder::findOrFail($id);

        if ($returnOrder->status !== 'refunded') {
            return redirect()->back()->with([
                'message' => 'Only refunded orders can be deleted.',
                'alert-type' => 'error',
            ]);
        }

        $returnOrder->delete();

        return redirect()->back()->with([
            'message' => 'Return order deleted successfully.',
            'alert-type' => 'success',
        ]);
    }
}
