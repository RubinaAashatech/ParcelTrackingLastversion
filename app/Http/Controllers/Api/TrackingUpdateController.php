<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrackingUpdate;
use App\Models\Parcel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrackingUpdateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $trackingUpdates = TrackingUpdate::with('parcel')
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('parcel_id');

            $parcelHistories = $trackingUpdates->map(function ($updates, $parcelId) {
                $parcel = $updates->first()->parcel;
                $latestUpdate = $updates->first();
    
                return [
                    'id' => $parcel->id,
                    'tracking_number' => $parcel->tracking_number,
                    'carrier' => $parcel->carrier,
                    'sending_date' => $parcel->sending_date,
                    'weight' => $parcel->weight,
                    'description' => $parcel->description,
                    'estimated_delivery_date' => $parcel->estimated_delivery_date,
                    'latest_tracking_update' => [
                        'id' => $latestUpdate->id,
                        'status' => $latestUpdate->status,
                        'location' => $latestUpdate->location,
                        'description' => $latestUpdate->description,
                        'notes' => $latestUpdate->notes,
                        'created_at' => $latestUpdate->created_at->toDateTimeString(),
                    ]
                ];
            });
    
            return response()->json($parcelHistories);
        }
        $trackingUpdates = TrackingUpdate::with('parcel.receiver')->latest()->paginate(10);
        $parcels = Parcel::with('receiver')->get();
        return view('admin.trackingupdates.index', compact('trackingUpdates', 'parcels'));
    }
    
    public function updateStatus(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tracking_update_id' => 'required|exists:tracking_updates,id',
            'status' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $trackingUpdate = TrackingUpdate::findOrFail($validated['tracking_update_id']);

        // Create a new status record
        TrackingUpdate::create([
            'parcel_id' => $trackingUpdate->parcel_id,
            'status' => $validated['status'],
            'location' => $validated['location'],
            'description' => $trackingUpdate->description,
            'notes' => $validated['notes'],
            'tracking_number' => $trackingUpdate->tracking_number,
        ]);

        return redirect()->route('api.tracking-updates.index')
            ->with('success', 'Tracking status updated successfully.');
    }

    public function edit(TrackingUpdate $trackingUpdate): View
    {
        $parcels = Parcel::all();
        return view('admin.trackingupdates.update', compact('trackingUpdate', 'parcels'));
    }

    public function update(Request $request, TrackingUpdate $trackingUpdate): RedirectResponse
    {
        $validated = $request->validate([
            'parcel_id' => 'required|exists:parcels,id',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
        ]);

        $parcel = Parcel::findOrFail($validated['parcel_id']);

        $trackingUpdate->update([
            'status' => $validated['status'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'notes' => $validated['notes'],
            'tracking_number' => $parcel->tracking_number,
        ]);

        return redirect()->route('api.tracking-updates.index')
            ->with('success', 'Tracking update updated successfully.');
    }

    public function destroy(TrackingUpdate $trackingUpdate): RedirectResponse
    {
        $trackingUpdate->delete();

        return redirect()->route('api.tracking-updates.index')
            ->with('success', 'Tracking update deleted successfully.');
    }
}
