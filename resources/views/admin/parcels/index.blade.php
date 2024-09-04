@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Parcels List</h1>
    <div class="mb-3">
        <a href="{{ route('api.parcels.create') }}" class="btn btn-primary">Add New Parcel</a>
    </div>

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

    <table class="table">
        <thead>
            <tr>
                <th>Tracking Number</th>
                <th>Customer</th>
                <th>Receiver</th>
                <th>Country</th>
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
                    <td>{{ $parcel->carrier }}</td>
                    <td>{{ $parcel->sending_date->format('Y-m-d') }}</td>
                    <td>{{ $parcel->weight }}</td>
                    <td>{{ $parcel->description }}</td>
                    <td>{{ $parcel->estimated_delivery_date->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('api.parcels.edit', $parcel) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('api.parcels.destroy', $parcel) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#forwardModal{{ $parcel->id }}">
                            +
                        </button>
                    </td>
                </tr>
                <!-- Forward Modal for each parcel -->
                <div class="modal fade" id="forwardModal{{ $parcel->id }}" tabindex="-1" aria-labelledby="forwardModalLabel{{ $parcel->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="forwardModalLabel{{ $parcel->id }}">Forward Parcel: {{ $parcel->tracking_number }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('api.parcels.forward', $parcel) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="forwarder_number{{ $parcel->id }}" class="form-label">Forwarding Number</label>
                                        <input type="text" class="form-control" id="forwarder_number{{ $parcel->id }}" name="forwarder_number" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection