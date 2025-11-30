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
        $brands = Brand::paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
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
                'message' => 'Brand created Successfully',
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
                'message' => 'Brand created Successfully',
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
        //
    }
}
