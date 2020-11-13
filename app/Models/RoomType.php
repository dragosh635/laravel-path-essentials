<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model {
    use HasFactory;

    /**
     * A room type has one room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function room() {
        return $this->hasOne( Room::class );
    }

    /**
     * A room type can be associated with more than one room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms() {
        return $this->hasMany( Room::class,'id', 'room_type_id' );
    }
}
