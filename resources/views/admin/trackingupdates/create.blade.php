@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Create New Tracking Update</h1>

    {{-- Uncomment this block if you want to display validation errors --}}
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <form action="{{ route('api.tracking-updates.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="parcel_id">Parcel</label>
            <select name="parcel_id" id="parcel_id" class="form-control">
                @foreach($parcels as $parcel)
                    <option value="{{ $parcel->id }}">{{ $parcel->tracking_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" id="status" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const parcelSelect = document.getElementById('parcel_id');
        const trackingNumberInput = document.getElementById('tracking_number');
        const statusInput = document.getElementById('status');
        const locationInput = document.getElementById('location');

        parcelSelect.addEventListener('change', function() {
            const selectedOption = parcelSelect.options[parcelSelect.selectedIndex];
            const trackingNumber = selectedOption.getAttribute('data-tracking');
            trackingNumberInput.value = trackingNumber ? trackingNumber : '';

            // Fetch the latest tracking data
            fetchTrackingData(trackingNumber);
        });

        async function fetchTrackingData(trackingNumber) {
            if (!trackingNumber) return;

            try {
                // Replace with your actual API endpoint
                const response = await fetch(`/api/tracking/${trackingNumber}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                // Update status and location fields with the fetched data
                statusInput.value = data.status || '';
                locationInput.value = data.location || '';
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }
    });
</script>
@endsection
