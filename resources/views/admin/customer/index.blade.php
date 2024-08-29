@extends('admin.layouts.master')
@section('content')
<div class="container">
        <h1>Customers List</h1>
        <a href="{{ route('api.customers.create') }}" class="btn btn-primary mb-3">Add New Customer</a>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Address</th>
                    <th>Phone No</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->fullname }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->phone_no }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <a href="{{ route('api.customers.edit', $customer) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('api.customers.destroy', $customer) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection






