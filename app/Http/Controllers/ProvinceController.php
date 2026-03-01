<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $provinces = Province::latest()->get();
        if ($request->ajax()) {

            return DataTables::of($provinces)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('province.edit', $row->id);
                    $deleteUrl = route('province.destroy', $row->id);

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
                ->rawColumns(['action'])
                ->make(true);
        }

        $totalProvince = count($provinces);

        return view('admin.shipping-area.province.index', compact('totalProvince'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
        ]);
        try {

            Province::create($validated);

            return redirect()->back()->with([
                'message' => 'Province Created Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in province creation '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Province Creation Failed',
                'alert-type' => 'error',
            ])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        return view('admin.shipping-area.province.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
        ]);
        try {

            $province->update($validated);

            return redirect()->route('province.index')->with([
                'message' => 'Province Updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in update province name '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Province Update Failed',
                'alert-type' => 'error',
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        try {
            $province->delete();

            return redirect()->back()->with([
                'message' => 'Province Deleted Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in delete province name '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Province delete Failed',
                'alert-type' => 'error',
            ]);
        }
    }
}
