<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    public function store(Request $request)
    {
        $couponValidate = $request->validate([
            'coupon_name' => 'required|string|unique:coupons,coupon_name',
            'coupon_discount' => 'required|numeric|min:0|max:100',
            'valid_until' => 'required|date',
        ]);
        try {
            Coupon::create($couponValidate);

            return redirect()->back()->with([
                'message' => 'Coupon Created Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in Coupon Creation '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Coupon Creation Failed',
                'alert-type' => 'error',
            ])->withInput();
        }
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
    public function update(Request $request, Coupon $coupon)
    {
        $couponValidate = $request->validate([
            'coupon_name' => 'required|string|unique:coupons,coupon_name,'.$coupon->id,
            'coupon_discount' => 'required|numeric|min:0|max:100',
            'valid_until' => 'required|date',
        ]);
        try {
            $coupon->update($couponValidate);

            return redirect()->route('coupon.index')->with([
                'message' => 'Coupon Updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in Coupon Updated '.$e->getMessage());

            return redirect()->route('coupon.index')->with([
                'message' => 'Coupon Updated Failed',
                'alert-type' => 'error',
            ])->withInput();
        }
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
