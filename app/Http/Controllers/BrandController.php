<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::latest()->get();
        if ($request->ajax()) {

            return DataTables::of($brands)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->brand_logo) {
                        $imageUrl = asset('images/brands/'.$row->brand_logo);

                        return '<img src="'.$imageUrl.'" alt="Brand Image"  class="img-thumbnail w-75 rounded">';
                    }

                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('brand.edit', $row->id);
                    $deleteUrl = route('brand.destroy', $row->id);

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
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        $totalBrands = $brands->count();

        return view('admin.brand.index', compact('totalBrands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|unique:brands,brand_name',
            'description' => 'required',
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        DB::beginTransaction();

        $logo = null;
        $fileName = null;

        try {
            if ($image = $request->file('logo')) {
                $destinationPath = public_path('images/brands/');

                if (! file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $fileName = uniqid('brands_').date('YmdHis').'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);
                $logo = $fileName;
            }

            Brand::create([
                'brand_name' => $request->name,
                'brand_description' => $request->description,
                'brand_logo' => $logo,
            ]);

            $notification = [
                'message' => 'Brand created Successfully',
                'alert-type' => 'success',
            ];

            DB::commit();

            return redirect()->route('brand.index')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();

            if ($fileName && file_exists(public_path('images/brands/'.$fileName))) {
                unlink(public_path('images/brands/'.$fileName));
            }

            Log::error('Brand creation failed '.$e->getMessage());

            $notification = [
                'message' => 'Brand creation failed ',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification)->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|min:5',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        DB::beginTransaction();

        $logo = $brand->brand_logo;
        $fileName = null;

        try {
            if ($image = $request->file('logo')) {
                $destinationPath = public_path('images/brands/');

                if (! file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $fileName = uniqid('brands_').date('YmdHis').'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);

                // Delete old logo if it exists
                if ($brand->brand_logo && file_exists(public_path('images/brands/'.$brand->brand_logo))) {
                    unlink(public_path('images/brands/'.$brand->brand_logo));
                }

                $logo = $fileName;
            }

            $brand->update([
                'brand_name' => $request->name,
                'brand_description' => $request->description,
                'brand_logo' => $logo,
            ]);

            $notification = [
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'info',
            ];

            DB::commit();

            return redirect()->route('brand.index')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();

            if ($fileName && file_exists(public_path('images/brands/'.$fileName))) {
                unlink(public_path('images/brands/'.$fileName));
            }

            Log::error('Brand Update Failed: '.$e->getMessage());

            $notification = [
                'message' => 'Brand update failed',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        DB::beginTransaction();

        try {
            // Delete the logo file if it exists
            if ($brand->brand_logo && file_exists(public_path('images/brands/'.$brand->brand_logo))) {
                unlink(public_path('images/brands/'.$brand->brand_logo));
            }

            $brand->delete();

            DB::commit();

            $notification = [
                'message' => 'Brand Deleted Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('brand.index')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Brand deletion failed: '.$e->getMessage());

            $notification = [
                'message' => 'Brand deletion failed',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }
    }
}
