<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
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
                ->addColumn('brand_description', function ($row) {
                    return substr($row->brand_description, 0, 25).'...';
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
            'name' => 'required|unique:brands,brand_name',
            'description' => 'required',
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        DB::beginTransaction();

        $fileName = null;
        try {
            $manager = new ImageManager(new Driver);

            // Create Directory
            $destinationPath = public_path('images/brands');
            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Upload logo
            if ($img = $request->file('logo')) {
                $fileName = uniqid('brand_').'.'.$img->getClientOriginalExtension();
                $image = $manager->read($img);
                $image->scaleDown(191, 75)->save($destinationPath.'/'.$fileName);
            }

            Brand::create([
                'brand_name' => $request->name,
                'brand_description' => $request->description,
                'brand_logo' => $fileName ?? null,
            ]);

            DB::commit();

            return redirect()->route('brand.index')->with([
                'message' => 'Brand created Successfully',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            if ($fileName && file_exists(public_path('images/brands/'.$fileName))) {
                unlink(public_path('images/brands/'.$fileName));
            }

            Log::error('Brand creation failed '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Brand creation failed ',
                'alert-type' => 'error',
            ])->withInput();
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
            'name' => 'required|min:5|unique:brands,brand_name,'.$brand->id,
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        DB::beginTransaction();

        $newFileName = null;

        try {
            $oldLogo = $brand->brand_logo;
            $manager = new ImageManager(new Driver);

            $destinationPath = public_path('images/brands');
            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if ($img = $request->file('logo')) {
                $newFileName = uniqid('brand_').'.'.$img->getClientOriginalExtension();
                $manager->read($img)
                    ->scaleDown(191, 75)
                    ->save($destinationPath.'/'.$newFileName);

                if ($oldLogo && file_exists(public_path('images/brands/'.$oldLogo))) {
                    unlink(public_path('images/brands/'.$oldLogo));
                }
            }

            $brand->update([
                'brand_name' => $request->name,
                'brand_description' => $request->description,
                'brand_logo' => $newFileName ?? $oldLogo,
            ]);

            DB::commit();

            return redirect()->route('brand.index')->with([
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'info',
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            if ($newFileName && file_exists(public_path('images/brands/'.$newFileName))) {
                unlink(public_path('images/brands/'.$newFileName));
            }

            Log::error('Brand Update Failed: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Brand update failed',
                'alert-type' => 'error',
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        DB::beginTransaction();

        try {

            $brand->delete();

            DB::commit();

            // Delete the logo file if it exists
            if ($brand->brand_logo && file_exists(public_path('images/brands/'.$brand->brand_logo))) {
                unlink(public_path('images/brands/'.$brand->brand_logo));
            }

            return redirect()->route('brand.index')->with([
                'message' => 'Brand Deleted Successfully',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Brand deletion failed: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Brand deletion failed',
                'alert-type' => 'error',
            ]);
        }
    }
}
