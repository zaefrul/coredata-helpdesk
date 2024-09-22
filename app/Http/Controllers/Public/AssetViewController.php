<?php

namespace App\Http\Controllers\Public;

use App\Models\Asset;
use App\Http\Controllers\Controller;

class AssetViewController extends Controller
{
    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        return view('public.asset_detail', compact('asset'));
    }
}