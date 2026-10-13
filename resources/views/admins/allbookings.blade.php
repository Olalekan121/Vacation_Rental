@extends('layouts.admin')

@section('content')




<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">

                <div class="container">
                    @if (session()->has('update'))
                    <div class="alert alert-success">
                        {{ session()->get('update') }}
                    </div>
                    @endif
                </div>

                <div class="container">
                    @if (session()->has('delete'))
                    <div class="alert alert-success">
                        {{ session()->get('delete') }}
                    </div>
                    @endif
                </div>

                <h5 class="card-title mb-4 d-inline">Bookings</h5>

                <table class="table">
                    <thead>
                        <tr>
                            <!-- <th scope="col">#</th> -->
                            <th scope="col">Check in</th>
                            <th scope="col">Check out</th>
                            <!-- <th scope="col">Email</th>
                            <th scope="col">Phone number</th> -->
                            <th scope="col">Full name</th>
                            <th scope="col">Hotel name</th>
                            <th scope="col">Room name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Payment</th>
                            <th scope="col">Change status</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <!-- <th scope="row">{{$booking->id}}</th> -->
                            <td>{{$booking->check_in}}</td>
                            <td>{{$booking->check_out}}</td>
                            <!-- <td>{{$booking->email}}</td>
                            <td>{{$booking->phone_number}}</td> -->
                            <td>{{$booking->name}}</td>
                            <td>{{$booking->hotel_name}}</td>
                            <td>{{$booking->room_name}}</td>
                            <td>{{$booking->status}}</td>
                            <td>{{$booking->price}}</td>
                            <td><a href="{{route('bookings.edit.status', $booking->id)}}" class="btn btn-warning  text-center text-white ">change status</a></td>

                            <td><a href="{{route('bookings.delete', $booking->id)}}" class="btn btn-danger  text-center ">delete</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection