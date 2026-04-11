<?php

namespace App\Http\Controllers;

use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
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
    public function store(StoreCityRequest $request)
    {
        City::create($request->validated());

        return redirect()->back()->with([
            'message' => 'City Created Successfully',
            'alert-type' => 'success',
        ]);
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
    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update($request->validated());

        return redirect()->route('city.index')->with([
            'message' => 'City name updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->back()->with([
            'message' => 'City Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * For Update Province Status
     */
    public function CityStatus($id)
    {
        $city = City::findOrFail($id);

        $newStatus = $city->is_active == 0 ? 1 : 0;
        $city->update([
            'is_active' => $newStatus,
        ]);

        return redirect()->back()->with([
            'message' => 'Status Updated Successfully',
            'alert-type' => 'success',
        ]);
    }
}
