<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
     /**
     * Display a listing of the customers.
     *
     * @return JsonResponse|View
     */
    public function index(Request $request)
{
    if ($request->expectsJson()) {
        $customers = Customer::orderBy('created_at', 'desc')->get();
        return response()->json($customers);
    }

    $customers = Customer::orderBy('created_at', 'desc')->get();
    return view('admin.customer.index', compact('customers'));
}


    /**
     * Show the form for creating a new customer.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
        ]);
    
        $customer = Customer::create($request->all());
    
        if ($request->ajax()) {
            return response()->json([
                'id' => $customer->id,
                'fullname' => $customer->fullname,
            ], 201);
        }
    
        return redirect()->route('api.parcels.create')->with('success', 'Customer added successfully.');
    }
    /**
     * Display the specified customer.
     *
     * @param Customer $customer
     * @param Request $request
     * @return JsonResponse|View
     */
    public function show(Customer $customer, Request $request): JsonResponse|View
    {
        if ($request->expectsJson()) {
            return response()->json($customer);
        }
        return view('admin.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     *
     * @param Customer $customer
     * @return View
     */
    public function edit(Customer $customer): View
    {
        return view('admin.customer.update', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     *
     * @param Request $request
     * @param Customer $customer
     * @return JsonResponse|RedirectResponse
     */
    public function update(Request $request, Customer $customer): JsonResponse|RedirectResponse
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
        ]);

        $customer->update($request->all());

        if ($request->expectsJson()) {
            return response()->json($customer);
        }

        return redirect()->route('api.customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param Customer $customer
     * @return JsonResponse
     */
    public function destroy(Customer $customer): RedirectResponse
{
    try {
        $customer->delete();
        return redirect()->route('api.customers.index')->with('success', 'Customer deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->route('api.customers.index')->with('error', 'Failed to delete customer.');
    }
}
}
