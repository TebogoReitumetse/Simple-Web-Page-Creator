<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'title' => 'Settings',
            'settings' => [
                'site_name' => Setting::get('site_name', 'CMS Site'),
                'footer_tagline' => Setting::get('footer_tagline', ''),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:100'],
            'footer_tagline' => ['nullable', 'string', 'max:300'],
        ]);
        foreach ($data as $k => $v) {
            Setting::set($k, $v);
        }
        return back()->with('status', 'Settings saved.');
    }
}
