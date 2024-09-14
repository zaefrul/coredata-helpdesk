<?php

namespace App\Helper;

use App\Models\Setting;

class SettingHelper
{
    public static function get($field)
    {
        $setting = Setting::where('field', $field)->first();
        return $setting ? $setting->value : null;
    }

    public static function set($field, $value)
    {
        $setting = Setting::where('field', $field)->first();
        if($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            $setting = new Setting();
            $setting->field = $field;
            $setting->value = $value;
            $setting->save();
        }
    }

    public static function delete($field)
    {
        $setting = Setting::where('field', $field)->first();
        if($setting) {
            $setting->delete();
        }
    }

    public static function all($field)
    {
        return Setting::where('field', $field)->get();
    }

    public static function getLabel($field, $value)
    {
        $setting = Setting::where('field', $field)->where('value', $value)->first();
        return $setting ? $setting->label : null;
    }

    public static function getValue($field, $label)
    {
        $settingQuery = Setting::where('field', $field);

        if($label) {
            $settingQuery->where('label', $label);
        }
        $setting = $settingQuery->first();

        return $setting ? $setting->value : null;
    }

    public static function getLabelValue($field, $value)
    {
        $setting = Setting::where('field', $field)->where('value', $value)->first();
        return $setting ? $setting->label : null;
    }

    // email settings
    public static function turnOnEmailService()
    {
        $setting = Setting::where('field', 'email_service')->where('label', 'switch')->first();
        if($setting) {
            $setting->value = 'on';
            $setting->save();
        }
    }

    public static function turnOffEmailService()
    {
        $setting = Setting::where('field', 'email_service')->where('label', 'switch')->first();
        if($setting) {
            $setting->value = 'off';
            $setting->save();
        }
    }
}