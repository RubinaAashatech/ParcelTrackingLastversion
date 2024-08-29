<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcel;
use Illuminate\View\View;

class FrontViewController extends Controller
{

    public function index(): View
    {
        return view('index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);
    
        $parcel = Parcel::with('trackingUpdates', 'receiver')
            ->where('tracking_number', $request->tracking_number)
            ->first();
    
        if (!$parcel) {
            return response()->json(['error' => 'Parcel not found'], 404);
        }
    
        return response()->json([
            'parcel' => $parcel,
            'tracking_updates' => $parcel->trackingUpdates,
            'receiver' => $parcel->receiver
        ]);
    }
    
}
