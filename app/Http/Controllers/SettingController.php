<?php

namespace App\Http\Controllers;

use App\Helper\AssetHelper;
use App\Helper\SettingHelper;
use App\Models\Asset;
use App\Models\Contract;
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

    public function regenerateAssetQR()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        $assets = Asset::all();
        
        foreach($assets as $asset) {
            if($asset->qr_code_path)
            {
                // just try to unlink. if failed then ignore and continue to create new qr code.
                try { unlink(public_path($asset->qr_code_path)); } catch(\Exception $e) {}
            }

            if(!$asset->asset_number)
            {
                $asset->asset_number = AssetHelper::generateAssetNumber($asset);
            }

            $asset->qr_code_path = AssetHelper::generateAssetQRCode($asset);
            $asset->save();
        }

        return redirect()->route('admin.index')->with('success', 'Asset QR code has been regenerated');
    }

    public function qrsettingPage()
    {
        $contracts = Contract::with('customer')->get();
        return view('admin.assetqr', compact('contracts'));
    }
}
// Compare this snippet from app/Http/Controllers/AssetController.php: