<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = WebsiteSetting::firstOrNew([]);
        return view('backend.settings.index', compact('settings'));
    }
    
    /**
     * Update website settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required|string|max:100',
            'site_tagline' => 'nullable|string|max:200',
            'site_description' => 'nullable|string|max:500',
            'site_email' => 'nullable|email|max:100',
            'site_phone' => 'nullable|string|max:20',
            'site_whatsapp' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:255',
            
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'headmaster_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'google_analytics' => 'nullable|string',
            
            'headmaster_name' => 'nullable|string|max:100',
            'headmaster_nip' => 'nullable|string|max:30',
            'headmaster_message' => 'nullable|string',
            
            'school_npsn' => 'nullable|string|max:20',
            'school_nss' => 'nullable|string|max:50',
            'school_akreditation' => 'nullable|string|max:10',
            'school_operator_name' => 'nullable|string|max:100',
            'school_operator_email' => 'nullable|email|max:100',
            
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->except(['_token', '_method', 'site_logo', 'site_favicon', 'headmaster_photo']);
        
        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $logoName = 'logo-' . time() . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('uploads/settings', $logoName, 'public');
            $data['site_logo'] = 'storage/' . $logoPath;
            
            // Delete old logo if exists
            $oldSettings = WebsiteSetting::getSettings();
            if ($oldSettings->site_logo && file_exists(public_path($oldSettings->site_logo))) {
                unlink(public_path($oldSettings->site_logo));
            }
        }
        
        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $favicon = $request->file('site_favicon');
            $faviconName = 'favicon-' . time() . '.' . $favicon->getClientOriginalExtension();
            $faviconPath = $favicon->storeAs('uploads/settings', $faviconName, 'public');
            $data['site_favicon'] = 'storage/' . $faviconPath;
            
            // Delete old favicon if exists
            $oldSettings = WebsiteSetting::getSettings();
            if ($oldSettings->site_favicon && file_exists(public_path($oldSettings->site_favicon))) {
                unlink(public_path($oldSettings->site_favicon));
            }
        }
        
        // Handle headmaster photo upload
        if ($request->hasFile('headmaster_photo')) {
            $photo = $request->file('headmaster_photo');
            $photoName = 'headmaster-' . time() . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('uploads/settings', $photoName, 'public');
            $data['headmaster_photo'] = 'storage/' . $photoPath;
            
            // Delete old photo if exists
            $oldSettings = WebsiteSetting::getSettings();
            if ($oldSettings->headmaster_photo && file_exists(public_path($oldSettings->headmaster_photo))) {
                unlink(public_path($oldSettings->headmaster_photo));
            }
        }
        
        // Handle maintenance mode
        $data['maintenance_mode'] = $request->has('maintenance_mode') ? true : false;
        
        // Save settings
        WebsiteSetting::saveSettings($data);
        
        return redirect()->route('backend.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}