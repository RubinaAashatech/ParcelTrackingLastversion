@extends('admin.layouts.master')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    <style>
        body{
    margin: 0px;
    padding: 0px;
}
form {
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    max-width: 500px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}
input[type="text"], input[type="number"], input[type="file"]:focus {
    border-color: #66AFE9;
}
button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin-top: 15px;
    width: 20%;
    margin-left: 40%;
}
input[type="submit"]:hover {
    background-color: #0056B3;
}
input[type="text"], input[type="number"],input[type="file"], textarea, select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table, th, td {
    border: 1.5px solid black;
}
th, td {
    padding: 8px;
    text-align: center;
}
th {
    background-color: #85AFDC;
}
img {
    display: block;
    max-width: 100%;
    height: auto;
}
    </style>
</head>
<body>
    <h1>Add Customer</h1>
    <form action="{{route('api.customers.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="fullname">Full Name</label>
        <input type="text" name="fullname" value="{{old('fullname')}}" required>
        <label>Address:</label>
        <textarea name="address" value="{{old('address')}}"></textarea>
        <label for="number">Phone Number</label>
        <input type="text" name="phone_no">
        <label for="email">Email</label>
        <input type="text" name="email" value="{{old('email')}}" >
        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
    </form>
</body>
</html>
@endsection