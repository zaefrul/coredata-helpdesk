<?php

namespace App\Http\Controllers;

use App\Helper\SettingHelper;
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
            'value' => 'required:unique:settings,value',
        ]);

        $setting = new Setting();
        $setting->field = 'component_type';
        $setting->label = request('label');
        $setting->value = request('value');

        $setting->save();

        return redirect()->route('admin.components')->with('success', 'Component type has been updated successfully');
    }

    public function destroy_component_type($id)
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        $setting = Setting::findOrFail($id);
        $setting->delete();

        return redirect()->route('admin.components')->with('success', 'Component type has been deleted successfully');
    }

    public function turnEmailOn()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        SettingHelper::turnOnEmailService();

        return redirect()->route('admin.index')->with('success', 'Email notification has been turned on');
    }

    public function turnEmailOff()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        SettingHelper::turnOffEmailService();

        return redirect()->route('admin.index')->with('success', 'Email notification has been turned off');
    }
}
// Compare this snippet from app/Http/Controllers/AssetController.php: