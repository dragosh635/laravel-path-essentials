<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller {
    /**
     * Display a single room type along with all the rooms associated with it
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        Cache::get( 'key' );

        return view( 'roomTypes.index' )->with( 'roomTypes', RoomType::paginate() );
    }

    /**
     * Edit room type page
     *
     * @param RoomType $roomType
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit( RoomType $roomType ) {
        return view( 'roomTypes.edit' )->with( 'roomType', $roomType );
    }

    /**
     * Update the room type
     *
     * @param Request $request
     * @param RoomType $roomType
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( Request $request, RoomType $roomType ) {
        $roomType->picture = Storage::putFile( 'public', $request->file( 'picture' ) );
        $roomType->save();

        return redirect()->route( 'room_types.index' );
    }
}
