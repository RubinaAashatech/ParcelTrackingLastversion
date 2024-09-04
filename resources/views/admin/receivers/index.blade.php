@extends('admin.layouts.master')

@section('content')

<div class="container">
    <h1>Receivers List</h1>
    {{-- <a href="{{ route('api.receivers.create') }}" class="btn btn-primary mb-3">Add New Receiver</a> --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SN</th>
                <th>Fullname</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Street Address</th>
                <th>Postal Code</th>
                <th>Phone No</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receivers as $receiver)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $receiver->fullname }}</td>
                <td>{{ $receiver->country }}</td>
                <td>{{ $receiver->state }}</td>
                <td>{{ $receiver->city }}</td>
                <td>{{ $receiver->street_address }}</td>
                <td>{{ $receiver->postal_code }}</td>
                <td>{{ $receiver->phone_no }}</td>
                <td>{{ $receiver->email }}</td>
                <td>
                    <a href="{{ route('api.receivers.edit', $receiver) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('api.receivers.destroy', $receiver) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
