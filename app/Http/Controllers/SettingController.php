<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\UpdateSiteSettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::findOrFail(1);

        return view('admin.setting.site-settings.index', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteSettingRequest $request, Setting $setting)
    {
        $logo = $setting->logo;

        if ($img = $request->file('logo')) {
            $extension = $img->getClientOriginalExtension();
            $fileName = uniqid('logo_').time().'.'.$extension;
            $img->move('images/setting/', $fileName);

            if ($setting->logo && file_exists(public_path('images/setting/'.$setting->logo))) {
                unlink(public_path('images/setting/'.$setting->logo));
            }

            $logo = $fileName;
        }

        $setting->update(array_merge(
            collect($request->validated())->except('logo')->all(),
            ['logo' => $logo]
        ));

        $notification = [
            'message' => 'Settings Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
