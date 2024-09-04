@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Tracking Updates</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tracking Updates Table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>SN</th>
                {{-- <th>ID</th> --}}
                <th>Tracking Number</th>
                <th>Receiver Name</th>
                <th>Status</th>
                <th>Location</th>
                <th>Description</th>
                <th>Notes</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trackingUpdates as $index => $update)
            <tr id="row-{{ $update->id }}" data-disabled="false">
                <td>{{ $index + 1 }}</td>
                {{-- <td>{{ $update->id }}</td> --}}
                <td>{{ $update->tracking_number }}</td>
                <td>{{ $update->parcel->receiver->fullname ?? 'N/A' }}</td>
                <td>{{ $update->status }}</td>
                <td>{{ $update->location }}</td>
                <td>{{ $update->description }}</td>
                <td>{{ $update->notes }}</td>
                <td>{{ $update->created_at->format('Y-m-d') }}</td>
                <td>{{ $update->updated_at->format('Y-m-d') }}</td>
                <td>
                    {{-- <a href="{{ route('api.tracking-updates.edit', $update) }}" class="btn btn-warning btn-sm edit-btn">Edit</a> --}}
                    <button type="button" class="btn btn-info btn-sm update-status-btn" 
                            onclick="openUpdateStatusModal('{{ $update->id }}')">Update Status</button>
                    {{-- <button type="button" class="btn btn-danger btn-sm disable-btn" 
                            onclick="disableRow('{{ $update->id }}')">Disable</button> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $trackingUpdates->links() }}

    <!-- Modal for Updating Status -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">Update Tracking Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="update-status-form" method="POST" action="{{ route('api.tracking-updates.updateStatus') }}">
                    @csrf
                    <input type="hidden" name="tracking_update_id" id="tracking_update_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="KTM Nepal Logistics">KTM Nepal Logistics</option>
                                <option value="Nepal Custom Warehouse">Nepal Custom Warehouse</option>
                                <option value="In Transit Air">In Transit Air</option>
                                <option value="At Main Hub Custom Clearance">At Main Hub Custom Clearance</option>
                                <option value="Forwarding">Forwarding</option>
                                <option value="Received">Received</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function openUpdateStatusModal(trackingUpdateId) {
        document.getElementById('tracking_update_id').value = trackingUpdateId;
        var updateStatusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
        updateStatusModal.show();
    }
</script>
@endsection
