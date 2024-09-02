<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parcel;
use App\Models\TrackingUpdate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ParcelHistoryController extends Controller
{
     /**
     * Display a listing of the parcel histories.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $parcels = Parcel::with(['latestTrackingUpdate' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();  
    
            return response()->json($parcels);
        }
    
        $parcels = Parcel::with(['latestTrackingUpdate' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
        return view('admin.parcelhistory.index', compact('parcels'));
    }
    

    /**
     * Show the form for creating a new tracking update.
     */
    public function create(): View
    {
        $parcels = Parcel::all();
        return view('admin.parcelhistory.create', compact('parcels'));
    }

    /**
     * Store a newly created tracking update in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parcel_id' => 'required|exists:parcels,id',
            'status' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        TrackingUpdate::create($validated);

        return redirect()->route('api.parcel-histories.index')
            ->with('success', 'Tracking update created successfully.');
    }
}
