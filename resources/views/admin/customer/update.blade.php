@extends('admin.layouts.master')

@section('content')<html><html>
    <head>
        <title>Update</title>
        {{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">--}}
        {{-- <link rel="stylesheet" href={{asset('css/style.css')}}> --}}
    </head>
    <body>
                    <form action="{{ route('api.customers.update',$customer->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="">Full Name</label>
                            <input type="text" name="fullname" value="{{$customer->fullname}}" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Address</label>
                            <textarea name="address"  class="form-control">{{$customer->address}}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Phone Number</label>
                            <input type="text" name="phone_no" value="{{$customer->phone_no}}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" value="{{$customer->email}}" class="form-control">
                        </div>
                        
                        

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>

    </body>
</html>


@endsection