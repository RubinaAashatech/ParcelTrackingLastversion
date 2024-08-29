<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ReceiverController extends Controller
{
     /**
     * Display a listing of the receivers.
     *
     * @return JsonResponse|View
     */
   public function index(Request $request)
{
    if ($request->expectsJson()) {
        $receivers = Receiver::orderBy('created_at', 'desc')->get();
        return response()->json($receivers);
    }

    $receivers = Receiver::orderBy('created_at', 'desc')->get();
    return view('admin.receivers.index', compact('receivers'));
}

    /**
     * Show the form for creating a new receiver.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.receivers.create');
    }

    /**
     * Store a newly created receiver in storage.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:20',
            'email' => 'nullable|email|unique:receivers,email',
        ]);
    
        $receiver = Receiver::create($request->all());
    
        if ($request->ajax()) {
            return response()->json([
                'id' => $receiver->id,
                'fullname' => $receiver->fullname,
            ], 201);
        }
    
        return redirect()->route('api.parcels.create')->with('success', 'Receiver added successfully.');
    }

    /**
     * Display the specified receiver.
     *
     * @param Receiver $receiver
     * @param Request $request
     * @return JsonResponse|View
     */
    public function show(Receiver $receiver, Request $request): JsonResponse|View
    {
        if ($request->expectsJson()) {
            return response()->json($receiver);
        }

        return view('admin.receivers.show', compact('receiver'));
    }

    /**
     * Show the form for editing the specified receiver.
     *
     * @param Receiver $receiver
     * @return View
     */
    public function edit(Receiver $receiver): View
    {
        return view('admin.receivers.update', compact('receiver'));
    }

    /**
     * Update the specified receiver in storage.
     *
     * @param Request $request
     * @param Receiver $receiver
     * @return JsonResponse|RedirectResponse
     */
    public function update(Request $request, Receiver $receiver): JsonResponse|RedirectResponse
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:20',
            'phone_no' => 'required|string|max:255',
            'email' => 'nullable|email|unique:receivers,email,' . $receiver->id,
        ]);

        $receiver->update($request->all());

        if ($request->expectsJson()) {
            return response()->json($receiver);
        }

        return redirect()->route('api.receivers.index')->with('success', 'Receiver updated successfully.');
    }

    /**
     * Remove the specified receiver from storage.
     *
     * @param Receiver $receiver
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(Receiver $receiver): RedirectResponse
    {
        try {
            $receiver->delete();
            return redirect()->route('api.receivers.index')->with('success', 'Receiver deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('api.receivers.index')->with('error', 'Failed to delete receiver.');
        }
    }
}
