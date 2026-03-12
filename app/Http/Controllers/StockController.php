<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::latest()->get();
        if ($request->ajax()) {

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->product_thumbnail) {
                        $imageUrl = asset('images/products/thumbnail/'.$row->product_thumbnail);

                        return '<img src="'.$imageUrl.'" alt="Product Image" class="img-thumbnail w-50">';
                    }

                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('product_name', function ($row) {
                    if ($row->product_name) {
                        return '<span class="text-dark fw-semibold fs-6">'.$row->product_name.'</span>';
                    }

                    return '<span class="text-muted fst-italic fs-6">No Category</span>';
                })
                ->addColumn('selling_price', function ($row) {
                    if ($row->selling_price) {
                        return '<span class="text-dark fw-semibold fs-5">Rs.'.$row->selling_price.'</span>';
                    }

                    return '<span class="text-muted fst-italic fs-6">No Category</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        return '<span class="badge bg-primary fs-6">Active</span>';
                    } else {
                        return '<span class="badge bg-secondary fs-6">Inactive</span>';
                    }
                })
                ->addColumn('stock', function ($row) {
                    if ($row->product_qty) {
                        return '<span class="text-dark fw-semibold fs-5">'.$row->product_qty.'</span>';
                    }

                    return '<span class="text-muted fst-italic fs-6">Out Of Stock</span>';
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('stock.edit', $row->id);

                    if ($row->status === 'active') {
                        $btn = '<div class="fs-5">
                            <a href="'.$editUrl.'" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit info">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </div>';

                        return $btn;
                    }

                })
                ->rawColumns(['image', 'product_name', 'selling_price', 'status', 'stock', 'action'])
                ->make(true);
        }

        return view('admin.stock.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('status', 'active')->get();

        return view('admin.stock.add', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'stock' => 'required',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);
            $product->increment('product_qty', $request->stock);

            return redirect()->route('stock.index')->with([
                'message' => 'Stock add Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in add stock '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Failed to add stock',
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $products = Product::where('status', 'active')->get();
        $stock = Product::findOrFail($id);

        return view('admin.stock.edit', compact('stock', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'stock' => 'required',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);
            $product->update(['product_qty' => $request->stock]);

            return redirect()->route('stock.index')->with([
                'message' => 'Stock Updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in update stock '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Failed to update stock',
                'alert-type' => 'error',
            ]);
        }
    }
}
