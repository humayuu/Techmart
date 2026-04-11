<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coupon = Coupon::query();
        if ($request->ajax()) {

            return DataTables::of($coupon)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if (now()->format('Y-m-d') > $row->valid_until) {
                        return '<span class="badge bg-warning text-dark fs-6">Expired</span>';
                    } else {
                        return '<span class="badge bg-primary fs-6">Active</span>';
                    }
                })
                ->addColumn('valid_until', function ($row) {
                    return '<span class="badge bg-dark fs-6">'.$row->valid_until.'</span>';
                })
                ->addColumn('coupon_discount', function ($row) {
                    return '<span class="badge bg-secondary fs-6">'.$row->coupon_discount.' %</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('coupon.edit', $row->id);
                    $deleteUrl = route('coupon.destroy', $row->id);

                    $btn = '<div class="d-flex align-items-center gap-3 fs-5">
                            <a href="'.$editUrl.'" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit info">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <form method="POST" action="'.$deleteUrl.'" class="d-inline m-0 delete-form">
                            '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" id="delete" class="text-danger border-0 bg-transparent p-0 d-inline-flex align-items-center delete-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" style="cursor: pointer; line-height: 1;">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>';

                    return $btn;
                })
                ->rawColumns(['action', 'status', 'valid_until', 'coupon_discount'])
                ->make(true);
        }

        $totalCoupons = $coupon->count();

        return view('admin.coupon.index', compact('totalCoupons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        Coupon::create($request->validated());

        return redirect()->back()->with([
            'message' => 'Coupon Created Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit', compact('coupon'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        return redirect()->route('coupon.index')->with([
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupon.index')->with([
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success',
        ]);

    }
}
