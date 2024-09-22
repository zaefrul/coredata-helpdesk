<?php

namespace App\Helper;

use App\Models\Asset;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;
use Illuminate\Support\Facades\Log;

class AssetHelper
{
    public static function generateAssetQRCode(Asset $asset)
    {
        $logoPath = public_path('images/coredata-logo-only.png');
        $url = route('public.assets.show', $asset->id);

        try
        {
            // Generate the QR code with the logo
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($url)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->logoPath($logoPath)
                ->logoResizeToWidth(60)
                ->logoResizeToHeight(60)
                ->logoPunchoutBackground(true)
                ->labelText($asset->asset_number)
                ->labelFont(new OpenSans(20))
                ->labelAlignment(LabelAlignment::Center)
                ->validateResult(false)
                ->build();

            // Save the QR code to a specific path
            if(!is_dir(public_path('qrcodes')))
            {
                mkdir(public_path('qrcodes'));
            }
            //generate the QR code file name
            $filename = 'asset-qrcode-' . date('Y-m-d-H-i-s') . '_' . $asset->id . '.png';

            $result->saveToFile(public_path('qrcodes') . '/' . $filename);

            $qrCodePath = 'qrcodes/' . $filename;

            // Update the asset with the QR code path
            return $qrCodePath;
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            throw new \Exception('Failed to generate QR code');
        }
    }

    public static function generateAssetNumber(Asset $asset)
    {
        $assetNumber = 'CRDT-' . date('Y') . '-' . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

        if(Asset::where('asset_number', $assetNumber)->exists())
        {
            return self::generateAssetNumber($asset);
        }

        return $assetNumber;
    }
}