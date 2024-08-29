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
                                <input type="text" class="form-control border-success" id="tracking_number" name="tracking_number" placeholder="Enter your tracking number" required>
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
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }
    .container {
        max-width: 1000px;
    }
    h1 {
        color: #2c3e50;
        font-weight: 700;
    }
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-title {
        color: #3498db;
        font-weight: bold;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
    }
    .table th {
        background-color: #f1f8ff;
        color: #2c3e50;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }
    .alert-danger {
        background-color: #ffebee;
        color: #c62828;
        border-radius: 10px;
        border: none;
    }
    .btn-success {
        background-color: #2ecc71;
        border-color: #2ecc71;
        transition: all 0.3s ease;
    }
    .btn-success:hover {
        background-color: #27ae60;
        border-color: #27ae60;
        transform: translateY(-2px);
    }
    .info-section {
        margin-bottom: 1.5rem;
    }
    .info-title {
        font-weight: bold;
        color: #3498db;
        margin-bottom: 1rem;
    }
    .inner-card {
        height: 100%;
    }
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

        $('#trackingForm').submit(function(e) {
            e.preventDefault();
            var trackingNumber = $('#tracking_number').val();
            $.ajax({
                url: '{{ route("api.track") }}',
                method: 'POST',
                data: { tracking_number: trackingNumber },
                dataType: 'json',
                success: function(response) {
                    var parcel = response.parcel;
                    var updates = response.tracking_updates;
                    var receiver = response.receiver;
                    var html = '<div class="card shadow-lg">' +
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
                        '<tr><th>Dispatched Date</th><td>' + new Date(parcel.sending_date).toLocaleDateString() + '</td>' +
                        '<tr><th>Weight</th><td>' + parcel.weight + ' kg</td></tr>' +
                        '<tr><th>Estimated Delivery</th><td>' + new Date(parcel.estimated_delivery_date).toLocaleDateString() + '</td></tr>' +
                        '</tbody>' +
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
                    console.error('Error:', status, error);
                    $('#result').html('<div class="alert alert-danger">Parcel not found or an error occurred</div>');
                }
            });
        });
    });
</script>
@endpush