@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Parcel History</h1>

    {{-- Display success message if any --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Display a table of parcel histories --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>SN</th>
                {{-- <th>Parcel ID</th> --}}
                <th>Tracking Number</th>
                <th>Carrier</th>
                <th>Current Status</th>
                <th>Current Location</th>
                <th>Description</th>
                <th>Last Update</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parcels as $index => $parcel)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    {{-- <td>{{ $parcel->id }}</td> --}}
                    <td>{{ $parcel->tracking_number }}</td>
                    <td>{{ $parcel->carrier }}</td>
                    <td>{{ $parcel->latestTrackingUpdate->status ?? 'N/A' }}</td>
                    <td>{{ $parcel->latestTrackingUpdate->location ?? 'N/A' }}</td>
                    <td>{{ $parcel->latestTrackingUpdate->description ?? 'N/A' }}</td>
                    <td>{{ $parcel->latestTrackingUpdate ? $parcel->latestTrackingUpdate->created_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No parcel history found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
