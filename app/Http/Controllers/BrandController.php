<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;
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
    public function store(StoreBrandRequest $request)
    {
        $manager = new ImageManager(new Driver);

        $destinationPath = public_path('images/brands');
        if (! is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $fileName = null;
        if ($img = $request->file('logo')) {
            $fileName = uniqid('brand_').'.'.$img->getClientOriginalExtension();
            $manager->read($img)
                ->coverDown(300, 150)
                ->save($destinationPath.'/'.$fileName);
        }

        try {
            Brand::create([
                'brand_name' => $request->name,
                'brand_description' => $request->description,
                'brand_logo' => $fileName ?? null,
            ]);
        } catch (Throwable $e) {
            if ($fileName && file_exists($destinationPath.'/'.$fileName)) {
                unlink($destinationPath.'/'.$fileName);
            }
            Log::error('Brand creation failed '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Brand creation failed ',
                'alert-type' => 'error',
            ])->withInput();
        }

        return redirect()->route('brand.index')->with([
            'message' => 'Brand created Successfully',
            'alert-type' => 'success',
        ]);
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
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $oldLogo = $brand->brand_logo;
        $manager = new ImageManager(new Driver);

        $destinationPath = public_path('images/brands');
        if (! is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $newFileName = null;

        if ($img = $request->file('logo')) {
            $newFileName = uniqid('brand_').'.'.$img->getClientOriginalExtension();
            $manager->read($img)
                ->coverDown(300, 150)
                ->save($destinationPath.'/'.$newFileName);

            if ($oldLogo && file_exists(public_path('images/brands/'.$oldLogo))) {
                unlink(public_path('images/brands/'.$oldLogo));
            }
        }

        try {
            $brand->update([
                'brand_name' => $request->name,
                'brand_description' => $request->description,
                'brand_logo' => $newFileName ?? $oldLogo,
            ]);
        } catch (Throwable $e) {
            if ($newFileName && file_exists($destinationPath.'/'.$newFileName)) {
                unlink($destinationPath.'/'.$newFileName);
            }
            Log::error('Brand Update Failed: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Brand update failed',
                'alert-type' => 'error',
            ])->withInput();
        }

        return redirect()->route('brand.index')->with([
            'message' => 'Brand Updated Successfully',
            'alert-type' => 'info',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $logo = $brand->brand_logo;
        $brand->delete();

        if ($logo && file_exists(public_path('images/brands/'.$logo))) {
            unlink(public_path('images/brands/'.$logo));
        }

        return redirect()->route('brand.index')->with([
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }
}
