<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\UpdateSeoSettingRequest;
use App\Models\SeoSetting;

class SeoSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seoSettings = SeoSetting::find(1);

        return view('admin.setting.seo-settings.index', compact('seoSettings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeoSettingRequest $request, $id)
    {
        $seoSetting = SeoSetting::findOrFail($id);
        $seoSetting->update($request->validated());

        return redirect()->back()->with([
            'message' => 'Settings Updated Successfully',
            'alert-type' => 'success',
        ]);
    }
}
