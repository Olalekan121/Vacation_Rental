<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Booking;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function myBookings()
    {
        $bookings = Booking::select()->orderby('id', 'desc')
        ->where('user_id', Auth::user()->id)->get();

        return view('users.bookings', compact('bookings'));
       
    }

}
