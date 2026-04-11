<?php

namespace App\Http\Controllers;

use App\Http\Requests\Slider\StoreSliderRequest;
use App\Http\Requests\Slider\UpdateSliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sliders = Slider::latest()->get();
        if ($request->ajax()) {

            return DataTables::of($sliders)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->slider_image) {
                        $imageUrl = asset('images/slider/'.$row->slider_image);

                        return '<img src="'.$imageUrl.'" alt="slider Image" class="img-thumbnail w-75 rounded">';
                    }

                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        return '<span class="badge bg-primary fs-6">Active</span>';
                    } else {
                        return '<span class="badge bg-secondary fs-6">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('slider.edit', $row->id);
                    $deleteUrl = route('slider.destroy', $row->id);
                    $statusUrl = route('slider.status', $row->id);
                    $class = $row->status == 'active' ? 'success' : 'dark';
                    $icon = $row->status == 'active' ? 'thumbs-up' : 'thumbs-down';

                    $btn = '<div class="d-flex align-items-center gap-3 fs-5">
                            <a href="'.$editUrl.'" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit info">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="'.$statusUrl.'"
                            class="text-'.$class.'" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Edit info">
                            <i class="bi bi-hand-'.$icon.'-fill"></i>
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
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        $totalSliders = $sliders->count();

        return view('admin.slider.index', compact('totalSliders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request)
    {
        $destinationPath = public_path('images/slider');
        if (! is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $img = $request->file('slider');
        $fileName = uniqid('slider_').'.'.$img->getClientOriginalExtension();

        $manager = new ImageManager(new Driver);
        $manager->read($img)
            ->coverDown(1920, 600)
            ->save($destinationPath.'/'.$fileName);

        try {
            Slider::create([
                'slider_image' => $fileName,
                'title' => $request->title,
                'status' => 'active',
            ]);
        } catch (Throwable $e) {
            if (file_exists($destinationPath.'/'.$fileName)) {
                unlink($destinationPath.'/'.$fileName);
            }
            Log::error('Slider creation failed: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Slider creation failed',
                'alert-type' => 'error',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Slider created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $destinationPath = public_path('images/slider');
        if (! is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $oldSlider = $slider->slider_image;
        $fileName = $oldSlider;

        if ($img = $request->file('slider')) {
            $fileName = uniqid('slider_').'.'.$img->getClientOriginalExtension();

            $manager = new ImageManager(new Driver);
            $manager->read($img)
                ->coverDown(1920, 600)
                ->save($destinationPath.'/'.$fileName);

            if ($oldSlider && file_exists($destinationPath.'/'.$oldSlider)) {
                unlink($destinationPath.'/'.$oldSlider);
            }
        }

        try {
            $slider->update([
                'title' => $request->title,
                'slider_image' => $fileName,
            ]);
        } catch (Throwable $e) {
            if ($fileName !== $oldSlider && file_exists($destinationPath.'/'.$fileName)) {
                unlink($destinationPath.'/'.$fileName);
            }
            Log::error('Slider Update Failed: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Slider update failed',
                'alert-type' => 'error',
            ])->withInput();
        }

        return redirect()->route('slider.index')->with([
            'message' => 'Slider updated successfully',
            'alert-type' => 'info',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->slider_image && file_exists(public_path('images/slider/'.$slider->slider_image))) {
            unlink(public_path('images/slider/'.$slider->slider_image));
        }

        $slider->delete();

        return redirect()->back()->with([
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Update slider status
     */
    public function SliderStatus($id)
    {
        $slider = Slider::findOrFail($id);

        $newStatus = $slider->status == 'active' ? 'inactive' : 'active';

        $slider->update([
            'status' => $newStatus,
        ]);

        return redirect()->back()->with([
            'message' => 'Status Updated Successfully',
            'alert-type' => 'success',
        ]);
    }
}
