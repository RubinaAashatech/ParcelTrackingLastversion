@extends('admin.layouts.master')

@section('content')

<div class="container">
    <h1>Edit Parcel</h1>
    <form action="{{ route('api.parcels.update', $parcel) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="tracking_number">Tracking Number</label>
            <input type="text" class="form-control" id="tracking_number" name="tracking_number" value="{{ $parcel->tracking_number }}" required>
        </div>
        
        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select class="form-control" id="customer_id" name="customer_id" required onchange="this.form.submit()">
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $customer->id == $parcel->customer_id ? 'selected' : '' }}>
                        {{ $customer->fullname }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="receiver_id">Receiver</label>
            <select class="form-control" id="receiver_id" name="receiver_id" required onchange="this.form.submit()">
                @foreach($receivers as $receiver)
                    <option value="{{ $receiver->id }}" {{ $receiver->id == $parcel->receiver_id ? 'selected' : '' }}>
                        {{ $receiver->fullname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="receiving_address_country">Country</label>
            <input type="text" class="form-control" id="receiving_address_country" name="receiving_address_country" value="{{ old('receiving_address_country', $parcel->receiver->country) }}" required>
        </div>
        <div class="form-group">
            <label for="receiving_address_state">State</label>
            <input type="text" class="form-control" id="receiving_address_state" name="receiving_address_state" value="{{ old('receiving_address_state', $parcel->receiver->state) }}" required>
        </div>
        <div class="form-group">
            <label for="receiving_address_city">City</label>
            <input type="text" class="form-control" id="receiving_address_city" name="receiving_address_city" value="{{ old('receiving_address_city', $parcel->receiver->city) }}" required>
        </div>

        <div class="form-group">
            <label for="receiving_address_street"> Street Address</label>
            <input type="text" class="form-control" id="receiving_address_street" name="receiving_address_street" value="{{ old('receiving_address_street', $parcel->receiver->street_address) }}" required>
        </div>
        <div class="form-group">
            <label for="receiving_address_postal_code">Postal Code</label>
            <input type="text" class="form-control" id="receiving_address_postal_code" name="receiving_address_postal_code" value="{{ old('receiving_address_postal_code', $parcel->receiver->postal_code) }}" required>
        </div>

        <div class="form-group">
            <label for="carrier">Carrier</label>
            <input type="text" class="form-control" id="carrier" name="carrier" value="{{ old('carrier', $parcel->carrier) }}" required>
        </div>
        <div class="form-group">
            <label for="sending_date">Sending Date</label>
            <input type="date" class="form-control" id="sending_date" name="sending_date" value="{{ old('sending_date', $parcel->sending_date->format('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
            <label for="weight">Weight</label>
            <input type="number" class="form-control" id="weight" name="weight" step="0.01" value="{{ old('weight', $parcel->weight) }}" required>
        </div>
        <div class="form-group">
            <label for="description">description</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $parcel->description) }}" >
        </div>
        <div class="form-group">
            <label for="estimated_delivery_date">Estimated Delivery Date</label>
            <input type="date" class="form-control" id="estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date', $parcel->estimated_delivery_date->format('Y-m-d')) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Parcel</button>
    </form>
</div>

@endsection
