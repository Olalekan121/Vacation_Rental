<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use App\Models\Hotel\Hotel;
use App\Models\Apartment\Apartment;
use App\Models\Booking\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class AdminsController extends Controller
{
    public function viewLogin(){
        return view('admins.login');
    }

    public function checkLogin(Request $request) {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            
            return redirect() -> route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);

    }

    public function index(){

        $adminsCount = Admin::select()->count();
        $hotelsCount = Hotel::select()->count();
        $roomsCount = Apartment::select()->count();

        return view('admins.index', compact('adminsCount', 'hotelsCount', 'roomsCount'));
    }

     public function allAdmins()
    {
        $admins = Admin::select()->orderby('id', 'desc')->get();

        return view('admins.alladmins', compact('admins'));
    }

    public function createAdmins()
    {
        return view('admins.createadmins');
    }

    public function storeAdmins(Request $request)
    {
        $storeAdmin = Admin::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        if ($storeAdmin) {
            return Redirect::route('admins.all')->with(['success' => 'Admin created successfully']);
        }
    }

    public function allHotels()
    {
        $hotels = Hotel::select()->orderby('id', 'desc')->get();

        return view('admins.allhotels', compact('hotels'));
    }

     public function createHotels() {
        return view('admins.createhotels');
    }
    
     public function storeHotels(Request $request){

        Request()->validate([
            'name' => 'required|max:40',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'location' => 'required|max:40',
        ]);

         $destinationPath = 'assets/images/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        $storeHotel = Hotel::create([
            "name" => $request->name,
            "image" => $myimage,
            "description" => $request->description,
            "location" => $request->location,
        ]);

        if ($storeHotel) {

            return Redirect::route('hotels.all')->with(['success' => 'Hotel created successfully']);
        }
    }

    public function editHotels($id) {
        $hotel = Hotel::find($id);
        return view('admins.edithotels', compact('hotel'));
    }

    public function updateHotels(Request $request, $id){


        Request()->validate([
            'name' => 'required|max:40',
            'description' => 'required',
            'location' => 'required|max:40',
        ]);

        $hotel = Hotel::find($id);

        $hotel->update(request()->all());

        if ($hotel) {
            return Redirect::route('hotels.all')->with(['update' => 'Hotel updated successfully']);
        }
    }

    public function deleteHotels($id){
        
        $hotel = Hotel::find($id);

         if(File::exists(public_path('assets/images/' . $hotel->image))){
            File::delete(public_path('assets/images/' . $hotel->image));
        }else{
            //dd('File does not exists.');
        }

        $hotel->delete();

        if ($hotel) {
            return Redirect::route('hotels.all')->with(['delete' => 'Hotel deleted successfully']);
        }
    }

    public function allRooms(){
        $rooms = Apartment::select()->orderby('id', 'desc')->get();

        return view('admins.allrooms', compact('rooms'));
    }

    public function createRooms(){

        $hotels = Hotel::all();

        return view('admins.createrooms', compact('hotels'));
    }

    public function storeRooms(Request $request){

        Request()->validate([
            'name' => 'required|max:40',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric|min:0',
            'max_persons' => 'required|integer|min:1',
            'size' => 'required|max:40',
            'view' => 'required|max:40',
            'num_beds' => 'required|integer|min:1',
            'hotel_id' => 'required|exists:hotels,id',
        ]);

         $destinationPath = 'assets/images/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        $storeRooms = Apartment::create([

            "name" => $request->name,
            "image" => $myimage,
            "max_persons" => $request->max_persons,
            "size" => $request->size,
            "view" => $request->view,
            "num_beds" => $request->num_beds,
            "price" => $request->price,
            "hotel_id" => $request->hotel_id,
        ]);

        if ($storeRooms) {

            return Redirect::route('rooms.all')->with(['success' => 'Room created successfully']);
        }
    }

    public function deleteRooms($id){
        
        $room = Apartment::find($id);

          if(File::exists(public_path('assets/images/' . $room->image))){
            File::delete(public_path('assets/images/' . $room->image));
        }else{
            //dd('File does not exists.');
        }

        $room->delete();

        if ($room) {
            return Redirect::route('rooms.all')->with(['delete' => 'Room deleted successfully']);
        }
    }

    public function allBookings()
    {
        $bookings = Booking::select()->orderby('id', 'desc')->get();

        return view('admins.allbookings', compact('bookings'));
    }

    public function editStatus($id) {
        $booking = Booking::find($id);
        return view('admins.editstatus', compact('booking'));
    }

    public function updateStatus(Request $request, $id){


        // Request()->validate([
        //     'name' => 'required|max:40',
        //     'description' => 'required',
        //     'location' => 'required|max:40',
        // ]);

        $status = Booking::find($id);

        $status->update(request()->all());

        if ($status) {
            return Redirect::route('bookings.all')->with(['update' => 'Status updated successfully']);
        }
    }

     public function deleteBookings($id){
        
        $booking = Booking::find($id);

        $booking->delete();

        if ($booking) {
            return Redirect::route('bookings.all')->with(['delete' => 'Booking deleted successfully']);
        }
    }
    
    
}