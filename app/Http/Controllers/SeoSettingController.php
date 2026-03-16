<?php

namespace App\Http\Controllers;

use App\Models\SeoSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function update(Request $request, $id)
    {
        $seoSetting = SeoSetting::findOrFail($id);
        $validateSettings = $request->validate([
            'meta_title' => 'required|string|max:60',
            'meta_author' => 'required|string|max:100',
            'meta_keyword' => 'required|string|max:255',
            'meta_description' => 'required|string|max:160',
            'google_analytics' => 'required|string|max:50',
        ]);

        try {
            $seoSetting->update($validateSettings);

            return redirect()->back()->with([
                'message' => 'Settings Updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in Update settings '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Error in Update settings',
                'alert-type' => 'error',
            ]);
        }
    }
}
