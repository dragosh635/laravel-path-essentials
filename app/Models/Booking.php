<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Booking extends Model {

    use HasFactory;

    use SoftDeletes;

    use Notifiable;

    /**
     * There are the fields that should be allowed to be saved for this model
     *
     * @var string[]
     */
    protected $fillable = [ 'room_id', 'start', 'end', 'is_reservation', 'is_paid', 'notes' ];

    /**
     * A bookings belongs to a room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo( Room::class );
    }

    /**
     * A booking can have more users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany( User::class,'bookings_users','booking_id','user_id' )->withTimestamps();
    }
}
