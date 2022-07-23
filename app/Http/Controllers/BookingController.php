<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Exception;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Rooms = Room::all();
        $Guests = Guest::all();

        if (request()->ajax()) {
            return $Bookings = Datatables::of(Booking::all())->addColumn('action','layouts.dt_buttons')->make(true);
        }
        return view('booking.index',compact('Rooms','Guests'));
        // $Bookings = Booking::select('bookings.*','rooms.RoomNo as Room','guests.Name as Guest')
        // ->leftJoin('rooms','bookings.RoomID','=','rooms.id')
        // ->leftJoin('guests','bookings.GuestID','=','guests.id')
        // ->get(); 

        // return view('booking.index',compact('Bookings','Rooms','Guests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Rooms = Room::all();
        $Guests = Guest::all();
        return view('booking.create',compact('Rooms', 'Guests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**return $request->all(); */
        try {
            Booking::create($request->all());
            Room::find($request->RoomID)->update(['Status' => 1]);
            return 'Booking Added Successfully !';
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  Booking::find($id);
        // return $Booking = Booking::select('bookings.*','rooms.RoomNo as Room','guests.Name as Guest')
        // ->where('bookings.id',$id)
        // ->leftJoin('rooms', 'bookings.RoomID', '=', 'rooms.id')
        // ->leftJoin('guests', 'bookings.GuestID', '=', 'guests.id')
        // ->first();   

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Rooms    = Room::all();
        $Guests   = Guest::all();
        $Booking  = Booking::find($id);
        // $Booking = Booking::select('bookings.*','rooms.RoomNo as Room','guests.Name as Guest')
        // ->where('bookings.id',$id)
        // ->leftJoin('rooms', 'bookings.RoomID', '=', 'rooms.id')
        // ->leftJoin('guests', 'bookings.GuestID', '=', 'guests.id')
        // ->get();   
        return view('booking.edit',compact('Rooms','Guests','Booking'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        /**$Booking = new Booking(); 
         * $Booking = Booking::find($request->id);
         * $Booking->CheckInDate   = $request->CheckInDate;
         * $Booking->CheckOutDate  = $request->CheckOutDate;
         * $Booking->update();
         * return $this->index();
         * 
        */ 
        
        Booking::find($id)->update($request->all());
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Booking::find($id)->delete();
        return back();
    }
    public function destroyAll()
    {
        Booking::withTrashed()->delete();
        return back()->with('DestroyAll', 'সমস্ত ডাটাকে খালি করা হলো');
    }
    public function trash()
    {
        $Bookings = Booking::onlyTrashed()->get();
        return view('booking.trash',compact('Bookings'));
    }
    public function restore($id)
    {
        Booking::withTrashed()->where('id',$id)->restore();
        return back()->with('Restore', 'Restore SuccessFully !');
    }
    public function restoreAll()
    {
        Booking::withTrashed()->restore();
        return back()->with('RestoreAll', 'সমস্ত ডাটাকে পুনরুদ্ধার করা হয়েছে');
    }
    public function forceDeleted($id)
    {
        Booking::withTrashed()->where('id',$id)->forceDelete();
        return back()->with('PermanentlyDelete', 'Permanently Delete Completed !');
    }
    public function emptyTrash()
    {
        Booking::onlyTrashed()->forceDelete();
        return back()->with('EmptyTrash', 'ট্রাস সম্পূর্ণরূপে খালি করা হলো');
    }
}
