<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function store_component_type(Request $request)
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        $request->validate([
            'label' => 'required',
            'value' => 'required',
        ]);

        $setting = new Setting();
        $setting->field = 'component_type';
        $setting->label = request('label');
        $setting->value = request('value');

        $setting->save();

        return redirect()->route('admin.components')->with('success', 'Component type has been updated successfully');
    }
}
// Compare this snippet from app/Http/Controllers/AssetController.php: