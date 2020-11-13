<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller {
    /**
     * Display the list of bookings
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        // Get also the room type data for the room
        // Get also the name for the user from each booking
        $bookings = Booking::with( [ 'room.roomType', 'users:name' ] )->paginate( 20 );

        return view( 'bookings.index' )->with( 'bookings', $bookings );
    }

    /**
     * Show the create view for a single booking
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
        $users = DB::table( 'users' )->get()->pluck( 'name', 'id' )->prepend( 'none' );
        $rooms = DB::table( 'rooms' )->get()->pluck( 'number', 'id' );

        return view( 'bookings.create' )
            ->with( 'users', $users )
            ->with( 'booking', ( new Booking() ) )
            ->with( 'rooms', $rooms );
    }

    /**
     * Save booking in the database
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( Request $request ) {
        $booking = Booking::create( $request->input() );

        /* Make the connection between the booking and the user */
        $booking->users()->attach( $request->input( 'user_id' ) );

        return redirect()->route( 'bookings.index' );
    }

    /**
     * Display the booking
     *
     * @param Booking $booking
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show( Booking $booking ) {
        return view( 'bookings.show' )->with( 'booking', $booking );
    }

    /**
     * Edit booking page
     *
     * @param Booking $booking
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit( Booking $booking ) {
        $users        = DB::table( 'users' )->get()->pluck( 'name', 'id' )->prepend( 'none' );
        $rooms        = DB::table( 'rooms' )->get()->pluck( 'number', 'id' );
        $bookingsUser = DB::table( 'bookings_users' )->where( 'booking_id', 'LIKE', $booking->id )->first();


        return view( 'bookings.edit' )
            ->with( 'booking', $booking )
            ->with( 'bookingUser', $bookingsUser )
            ->with( 'users', $users )
            ->with( 'rooms', $rooms );
    }

    /**
     * Update a booking
     *
     * @param Request $request
     * @param Booking $booking
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( Request $request, Booking $booking ) {

        $validatedData = $request->validate( [
            'start'          => 'required|date', // make sure it's a date
            'end'            => 'required|date',
            'room_id'        => 'required|exists:rooms,id', // make sure that the room id exists in the room table
            'user_id'        => 'required|exists:users,id', // make sure that the user id exists in the user table
            'is_paid'        => 'nullable',
            'notes'          => 'present',
            'is_reservation' => 'required',
        ] );
        $booking->fill( $validatedData );
        $booking->save();

        /* Update also the user link for the booking */
        $booking->users()->sync( [ $validatedData['user_id'] ] );

        return redirect()->route( 'bookings.index' );
    }

    /**
     * Delete a booking ( soft delete )
     *
     * @param Booking $booking
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy( Booking $booking ) {
        /* Remove also the connection with the user */
        $booking->users()->detach();

        $booking->delete();

        return redirect()->route( 'bookings.index' );
    }
}
