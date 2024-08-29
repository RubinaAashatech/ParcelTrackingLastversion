@extends('admin.layouts.master')

@section('content')

<div class="container">
    <h1>Parcels List</h1>
    <a href="{{ route('api.parcels.create') }}" class="btn btn-primary mb-3">Add New Parcel</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tracking Number</th>
                <th>Customer</th>
                <th>Receiver</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Street Address</th>
                <th>Postal Code</th>
                <th>Carrier</th>
                <th>Sending Date</th>
                <th>Weight</th>
                <th>Description</th>
                <th>Estimated Delivery Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parcels as $parcel)
            <tr>
                <td>{{ $parcel->tracking_number }}</td>
                <td>{{ $parcel->customer->fullname }}</td>
                <td>{{ $parcel->receiver->fullname }}</td>
                <td>{{ $parcel->receiver->country }}</td>
                <td>{{ $parcel->receiver->state }}</td>
                <td>{{ $parcel->receiver->city }}</td>
                <td>{{ $parcel->receiver->street_address }}</td>
                <td>{{ $parcel->receiver->postal_code }}</td>
                
                <td>{{ $parcel->carrier }}</td>
                <td>{{ $parcel->sending_date->format('Y-m-d') }}</td>
                <td>{{ $parcel->weight }}</td>
                <td>{{ $parcel->description }}</td>
                <td>{{ $parcel->estimated_delivery_date->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('api.parcels.edit', $parcel) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('api.parcels.destroy', $parcel) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this parcel?');">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
