<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Models\Room;

class ShowRoomsController extends Controller {
    /**
     * Shows all the rooms from the application
     *
     * @param Request $request
     * @param null $roomType
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke( Request $request, RoomType $roomType = null ) {
        $rooms = Room::byType( $roomType->id )->get();

        return view( 'rooms.index', [
            'rooms' => $rooms,
        ] );
    }
}
