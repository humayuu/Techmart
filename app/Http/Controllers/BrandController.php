<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        $totalBrands = $brands->count();
        return view('admin.brand.index', compact('brands', 'totalBrands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|unique:brands,brand_name',
            'description' => 'required',
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB max
        ]);

        DB::beginTransaction();

        $logo = null;
        $fileName = null;

        try {
            if ($image = $request->file('logo')) {
                $destinationPath = public_path('images/brands/');

                // Create directory for Upload
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $fileName = uniqid('brands_') . date('YmdHis') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);
                $logo = 'images/brands/' . $fileName;
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

            // Delete uploaded file if transaction failed
            if ($fileName && file_exists(public_path('images/brands/' . $fileName))) {
                unlink(public_path('images/brands/' . $fileName));
            }

            Log::error('Brand creation failed ' . $e->getMessage());

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
     */ public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|min:5',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', //2MB
        ]);

        DB::beginTransaction();

        $logo = $brand->brand_logo;
        $fileName = null;

        try {
            if ($image = $request->file('logo')) {
                $destinationPath = public_path('images/brands/');

                // Create directory if it doesn't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $fileName = uniqid('brands_') . date('YmdHis') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);
                $newLogo = 'images/brands/' . $fileName;

                // Delete old logo if it exists
                if ($brand->brand_logo && file_exists(public_path($brand->brand_logo))) {
                    unlink(public_path($brand->brand_logo));
                }

                $logo = $newLogo;
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

            // Delete uploaded file if transaction failed
            if ($fileName && file_exists(public_path('images/brands/' . $fileName))) {
                unlink(public_path('images/brands/' . $fileName));
            }

            Log::error('Brand Update Failed: ' . $e->getMessage());

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
            if ($brand->brand_logo && file_exists(public_path($brand->brand_logo))) {
                unlink(public_path($brand->brand_logo));
            }

            $brand->delete();

            DB::commit();

            $notification = [
                'message' => 'Brand Deleted Successfully',
                'alert-type' => 'success',
            ];

            DB::commit();
            return redirect()->route('brand.index')->with($notification);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Brand deletion failed: ' . $e->getMessage());

            $notification = [
                'message' => 'Brand deletion failed',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification)->withInput();
        }
    }
}
