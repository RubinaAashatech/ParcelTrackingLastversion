@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Create Parcel</h1>
    <form action="{{ route('api.parcels.create') }}" method="GET">
        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select class="form-control" id="customer_id" name="customer_id" onchange="this.form.submit()">
                <option value="">Select a Customer</option>
                @foreach($customers->sortByDesc('created_at') as $customer)
                    <option value="{{ $customer->id }}" {{ $selectedCustomer && $selectedCustomer->id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->fullname }}
                    </option>
                @endforeach
            </select>
            <button type="button" class="btn btn-sm btn-primary mt-2" data-toggle="modal" data-target="#addCustomerModal">
                Add New Customer
            </button>
        </div>
        <div class="form-group">
            <label for="receiver_id">Receiver</label>
            <select class="form-control" id="receiver_id" name="receiver_id" onchange="this.form.submit()">
                <option value="">Select a Receiver</option>
                @foreach($receivers->sortByDesc('created_at') as $receiver)
                    <option value="{{ $receiver->id }}" {{ $selectedReceiver && $selectedReceiver->id == $receiver->id ? 'selected' : '' }}>
                        {{ $receiver->fullname }}
                    </option>
                @endforeach
            </select>
            <button type="button" class="btn btn-sm btn-primary mt-2" data-toggle="modal" data-target="#addReceiverModal">
                Add New Receiver
            </button>
        </div>
    </form>

    <form action="{{ route('api.parcels.store') }}" method="POST">
        @csrf
        <input type="hidden" name="customer_id" value="{{ $selectedCustomer ? $selectedCustomer->id : '' }}">
        <input type="hidden" name="receiver_id" value="{{ $selectedReceiver ? $selectedReceiver->id : '' }}">
        
        <div class="form-group">
            <label for="receiver_country">Country</label>
            <input type="text" class="form-control" id="receiver_country" name="receiver_country" value="{{ $receiverCountry }}" readonly required>
        </div>
        <div class="form-group">
            <label for="receiver_state">State</label>
            <input type="text" class="form-control" id="receiver_state" name="receiver_state" value="{{ $receiverState }}" readonly required>
        </div>
        <div class="form-group">
            <label for="receiver_city">City</label>
            <input type="text" class="form-control" id="receiver_city" name="receiver_city" value="{{ $receiverCity }}" readonly required>
        </div>
        <div class="form-group">
            <label for="receiver_street_address">Street Address</label>
            <input type="text" class="form-control" id="receiver_street_address" name="receiver_street_address" value="{{ $receiverStreetAddress }}" readonly required>
        </div>
        <div class="form-group">
            <label for="receiver_postal_code">Postal Code</label>
            <input type="text" class="form-control" id="receiver_postal_code" name="receiver_postal_code" value="{{ $receiverPostalCode }}" readonly required>
        </div>
        <div class="form-group">
            <label for="carrier">Carrier</label>
            <input type="text" class="form-control" id="carrier" name="carrier" required>
        </div>
        <div class="form-group">
            <label for="sending_date">Sending Date</label>
            <input type="date" class="form-control" name="sending_date" value="{{ \Illuminate\Support\Carbon::now()->format('Y-m-d') }}">
        </div>
        <div class="form-group">
            <label for="weight">Weight</label>
            <input type="number" class="form-control" id="weight" name="weight" step="0.01" min="1" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" >
        </div>
        <div class="form-group">
            <label for="estimated_delivery_date">Estimated Delivery Date</label>
            <input type="date" class="form-control" id="estimated_delivery_date" name="estimated_delivery_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Parcel</button>
    </form>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCustomerForm" action="{{ route('api.customers.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="customer_fullname">Full Name</label>
                        <input type="text" class="form-control" id="customer_fullname" name="fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_no">Phone number</label>
                        <input type="number" class="form-control" id="phone_no" name="phone_no" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email</label>
                        <input type="email" class="form-control" id="customer_email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Receiver Modal -->
<div class="modal fade" id="addReceiverModal" tabindex="-1" role="dialog" aria-labelledby="addReceiverModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReceiverModalLabel">Add New Receiver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addReceiverForm" action="{{ route('api.receivers.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="receiver_fullname">Full Name</label>
                        <input type="text" class="form-control" id="receiver_fullname" name="fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" name="country" id="country" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State:</label>
                        <input type="text" name="state" id="state" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" name="city" id="city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="street_address">Street Address:</label>
                        <input type="text" name="street_address" id="street_address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code:</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="receiver_phone_no">Phone number</label>
                        <input type="number" class="form-control" id="receiver_phone_no" name="phone_no" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="receiver_email">Email</label>
                        <input type="email" class="form-control" id="receiver_email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Receiver</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('estimated_delivery_date').setAttribute('min', today);

    $('#addCustomerForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                $('#addCustomerModal').modal('hide');
                $('#customer_id').append(
                    `<option value="${data.id}">${data.fullname}</option>`
                );
                $('#customer_id').val(data.id);  // Set the value to select the new customer
                $('#customer_id').trigger('change');  // Trigger change event
            },
            error: function(xhr) {
                alert('Failed to add customer. ' + xhr.responseText);
            }
        });
    });

    $('#addReceiverForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                $('#addReceiverModal').modal('hide');
                $('#receiver_id').append(
                    `<option value="${data.id}">${data.fullname}</option>`
                );
                $('#receiver_id').val(data.id);  // Set the value to select the new receiver
                $('#receiver_id').trigger('change');  // Trigger change event
            },
            error: function(xhr) {
                alert('Failed to add receiver. ' + xhr.responseText);
            }
        });
    });
});
</script>
@endsection