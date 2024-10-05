<?php

namespace App\Http\Controllers;

use App\Helper\AssetHelper;
use App\Helper\SettingHelper;
use App\Models\Asset;
use App\Models\Contract;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function wallpaperPage()
    {
        // get all images from public/assets/images/mask folder
        $maskImages = glob(public_path('assets/images/mask/*'));
        // get all filename and extension
        $wallpapers = array_map('basename', $maskImages);
        return view('admin.background', compact('wallpapers'));
    }

    public function emailSettingsPage()
    {
        $contract_end_emails = Setting::where('field', 'contract_end_notification_mail')->first();
        return view('admin.emailsettings', compact('contract_end_emails'));
    }

    public function emailSettingsUpdate(Request $request)
    {
        $request->validate([
            'emailService' => 'required',
        ]);

        $setting = Setting::where('field', 'contract_end_notification_mail')->first();
        $setting->value = request('emailService');
        $setting->save();

        return back()->with('success', 'Email settings has been updated');
    }
}
// Compare this snippet from app/Http/Controllers/AssetController.php: