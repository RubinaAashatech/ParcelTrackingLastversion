<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcel;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Log;

class FrontViewController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function track(Request $request)
    {
        $trackingNumber = $request->input('tracking_number');

        if (!$trackingNumber) {
            return response()->json(['error' => 'No tracking number provided'], 400);
        }

        $parcel = Parcel::where('tracking_number', $trackingNumber)->first();
        if (!$parcel) {
            return response()->json(['error' => 'Parcel not found'], 404);
        }

        $receiver = $parcel->receiver;
        $updates = $parcel->trackingUpdates;

        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($trackingNumber, $generator::TYPE_CODE_128));

        return response()->json([
            'parcel' => $parcel,
            'receiver' => $receiver,
            'tracking_updates' => $updates,
            'barcode' => $barcode 
        ]);
    }

    // public function scanBarcode(Request $request)
    // {
    //     $redirectUrl = 'https://www.youtube.com/watch?v=NA6Baz79LlE'; 
    //     return response()->json(['redirectUrl' => $redirectUrl]);
    // }
    
}
