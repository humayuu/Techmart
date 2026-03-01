<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cities = City::latest()->get();
        $totalCities = count($cities);
        $provinces = Province::all();
        if ($request->ajax()) {

            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('is_active', function ($row) {
                    if ($row->is_active == 1) {
                        return '<span class="badge bg-primary fs-6">Active</span>';
                    } else {
                        return '<span class="badge bg-secondary fs-6">Inactive</span>';
                    }
                })
                ->addColumn('province_id', function ($row) {
                    return $row->province->name;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('city.edit', $row->id);
                    $deleteUrl = route('city.destroy', $row->id);
                    $statusUrl = route('city.status', $row->id);
                    $class = $row->is_active == 1 ? 'success' : 'dark';
                    $icon = $row->is_active == 1 ? 'thumbs-up' : 'thumbs-down';

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
                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }

        return view('admin.shipping-area.cities.index', compact('provinces', 'totalCities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'province_id' => 'required',
            'name' => 'required|max:30',
            'is_active' => 'required',
        ]);
        try {

            City::create($validated);

            return redirect()->back()->with([
                'message' => 'City Created Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in city creation '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'City Creation Failed',
                'alert-type' => 'error',
            ])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $provinces = Province::all();

        return view('admin.shipping-area.cities.edit', compact('provinces', 'city'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'province_id' => 'required',
            'name' => 'required|max:30',
        ]);
        try {

            $city->update($validated);

            return redirect()->route('city.index')->with([
                'message' => 'City name updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in update city name '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'City update Failed',
                'alert-type' => 'error',
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        try {
            $city->delete();

            return redirect()->back()->with([
                'message' => 'City Deleted Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in delete city name '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'City delete Failed',
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * For Update Province Status
     */
    public function CityStatus($id)
    {
        try {
            $city = City::findOrFail($id);

            $newStatus = $city->is_active == 0 ? 1 : 0;
            $city->update([
                'is_active' => $newStatus,
            ]);

            return redirect()->back()->with([
                'message' => 'Status Updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error updating city status: '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Status Update Failed',
                'alert-type' => 'error',
            ]);
        }
    }
}
