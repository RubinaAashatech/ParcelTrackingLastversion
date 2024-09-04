@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Track Your Parcel</h1>
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body">
                    <form id="trackingForm">
                        @csrf
                        <div class="form-group">
                            <label for="tracking_number" class="text-success font-weight-bold">Tracking Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control border-success" id="tracking_number" name="tracking_number" placeholder="Enter your tracking number" required autofocus>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success">Track Parcel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="result" class="mt-4">
        <!-- The results will be inserted here -->
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Your existing CSS styles */
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Check if there's a tracking number in URL parameters
    var urlParams = new URLSearchParams(window.location.search);
    var trackingNumber = urlParams.get('trackingNumber');
    if (trackingNumber) {
        $('#tracking_number').val(trackingNumber);
        $('#trackingForm').submit();
    }

    $('#trackingForm').submit(function(e) {
        e.preventDefault();
        var trackingNumber = $('#tracking_number').val();
        trackParcel(trackingNumber);
    });

    window.handleBarcodeResult = function(result) {
    $.ajax({
        url: '{{ route("api.scanBarcode") }}',
        method: 'POST',
        data: { url: 'https://ktmnepalogistic.com/' },
        dataType: 'json',
        success: function(response) {
                window.location.href = response.redirectUrl;
        },
    });
};

    function trackParcel(trackingNumber) {
        $.ajax({
            url: '{{ route("api.track") }}',
            method: 'POST',
            data: { tracking_number: trackingNumber },
            dataType: 'json',
            success: function(response) {
                if (!response.parcel || !response.tracking_updates || !response.receiver) {
                    $('#result').html('<div class="alert alert-danger">Parcel not found or incomplete data.</div>');
                    return;
                }

                var parcel = response.parcel;
                var updates = response.tracking_updates;
                var receiver = response.receiver;
                var barcode = response.barcode;

                var html = '<div class="text-center mt-4">' +
                    '<h5 class="text-success">Barcode</h5>' +
                    '<img src="data:image/png;base64,' + barcode + '" alt="Barcode" />' +
                    '</div>' +
                    '<div class="card shadow-lg mt-4">' +
                    '<div class="card-body">' +
                    '<div class="row mb-4">' +
                    '<div class="col-md-6">' +
                    '<div class="card inner-card">' +
                    '<div class="card-body">' +
                    '<h5 class="text-success card-title">Parcel Information</h5>' +
                    '<table class="table table-borderless">' +
                    '<tbody>' +
                    '<tr><th>Tracking Number</th><td>' + parcel.tracking_number + '</td></tr>' +
                    '<tr><th>Carrier</th><td>' + parcel.carrier + '</td></tr>' +
                    '<tr><th>Dispatched Date</th><td>' + new Date(parcel.sending_date).toLocaleDateString() + '</td></tr>' +
                    '<tr><th>Weight</th><td>' + parcel.weight + ' kg</td></tr>' +
                    '<tr><th>Estimated Delivery</th><td>' + new Date(parcel.estimated_delivery_date).toLocaleDateString() + '</td></tr>';

                if (parcel.forwarder_number) {
                    html += '<tr><th>Forwarding Number</th><td>' + parcel.forwarder_number + '</td></tr>';
                }

                html += '</tbody>' +
                    '</table>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<div class="card inner-card">' +
                    '<div class="card-body">' +
                    '<h5 class="text-success card-title">Receiver Information</h5>' +
                    '<table class="table table-borderless">' +
                    '<tbody>' +
                    '<tr><th>Name</th><td>' + receiver.fullname + '</td></tr>' +
                    '<tr><th>Address</th><td>' + 
                    receiver.country + ', ' + 
                    receiver.city + ', ' + 
                    receiver.state + ', ' + 
                    receiver.postal_code + 
                    '</td></tr>' +
                    '</tbody>' +
                    '</table>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="card">' +
                    '<div class="card-body">' +
                    '<h5 class="text-success card-title">Tracking Updates</h5>' +
                    '<table class="table table-striped">' +
                    '<thead>' +
                    '<tr><th>Date</th><th>Activity</th></tr>' +
                    '</thead>' +
                    '<tbody>';

                updates.forEach(function(update) {
                    html += '<tr>' +
                        '<td>' + new Date(update.created_at).toLocaleDateString() + '</td>' +
                        '<td>' + update.status + '</td>' +
                        '</tr>';
                });

                html += '</tbody>' +
                    '</table>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('#result').html(html);
            },
            error: function(xhr, status, error) {
                $('#result').html('<div class="alert alert-danger">Error: ' + error + '</div>');
            }
        });
    }
});
</script>
@endpush
