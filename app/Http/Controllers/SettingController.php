<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::findOrFail(1);

        return view('admin.setting.index', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'logo' => 'mimes:jpg,png,jpeg',
        ]);

        $logo = $setting->logo;
        $fileName = null;

        try {
            if ($img = $request->file('logo')) {
                $extension = $img->getClientOriginalExtension();
                $fileName = uniqid('logo_').time().'.'.$extension;
                $img->move('images/setting/', $fileName);

                // Delete old logo if it exists
                if ($setting->logo && file_exists(public_path('images/setting/'.$setting->logo))) {
                    unlink(public_path('images/setting/'.$setting->logo));
                }

                $logo = $fileName;
            }

            $setting->update([
                'logo' => $logo,
                'phone' => $request->phone,
                'email' => $request->email,
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'facebook' => $request->facebook,
                'x' => $request->x,
                'linkedin' => $request->linkedin,
                'youtube' => $request->youtube,
            ]);

            $notification = [
                'message' => 'Settings Updated Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);

        } catch (Exception $e) {
            Log::error('Error in Update settings '.$e->getMessage());

            $notification = [
                'message' => 'Error in Update settings',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

    }
}
