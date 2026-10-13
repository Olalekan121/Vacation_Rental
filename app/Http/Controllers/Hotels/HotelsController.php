<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment\Apartment;
use App\Models\Booking\Booking;
use App\Models\Hotel\Hotel;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class HotelsController extends Controller
{
    //



    public function rooms($id)
    {

        $getRooms = Apartment::select()->orderBy('id', 'desc')->take(6)
            ->where('Hotel_id', $id)->get();

        return view('hotels.rooms', compact('getRooms'));
    }






    public function roomDetails($id)
    {

        $getRoom = Apartment::find($id);

        return view('hotels.roomdetails', compact('getRoom'));
    }


    public function roomBooking(Request $request, $id){

        Request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
        ]);

        $room = Apartment::find($id);
        $hotel = Hotel::find($id);

        // dd(date("n/j/Y"), $request->check_in, $request->check_out);

        if (strval(date("n/j/Y")) < strval($request->check_in) && strval(date("n/j/Y")) < strval($request->check_out)) {

            ///Continue with the booking process

        
            $datetime1 = new DateTime($request->check_in);
            $datetime2 = new DateTime($request->check_out);

            if ($datetime1 < $datetime2) {

                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');

                $bookRooms = Booking::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    'days' => $days,
                    'price' => $days * $room->price,
                    'user_id' => Auth::user()->id,
                    'room_name' => $room->name,
                    'hotel_name' => $hotel->name,
                ]);

                $totalPrice = $days * $room->price;
                $price = Session::put('price', $totalPrice);

                $getPrice = Session::get($price);


                return Redirect::route('hotel.pay');
            } else {

                return Redirect::route('hotel.rooms.details', $room->id)->with(['error'=> 'Check in date must be less than check out date']);

            }
        } else {

            return Redirect::route('hotel.rooms.details', $room->id )->with(['error_dates'=> 'Choose dates in the future, invalid check in or check out date']);
        }
    }


    public function payWithPayPal()
        {
    
            return view('hotels.pay');
        }


     public function success()
        {

            Session::forget('price');
    
            return view('hotels.success');
        }    


}






