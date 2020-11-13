<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;

class Room extends Model {
    use HasFactory;

    /**
     * The table name, added here just for learning purposes
     *
     * @var string
     */
    protected $table = 'rooms';

    /**
     * Primary key of the table, added here just for learning purposes
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Enable timestamps for the model, added here just for learning purposes
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Query the rooms by room type
     *
     * @param $query
     * @param null $roomTypeId
     *
     * @return mixed
     */
    public function scopeByType( $query, $roomTypeId = null ) {
        if ( ! is_null( $roomTypeId ) ) {
            $query->where( 'room_type_id', $roomTypeId );
        }

        return $query;
    }

    /**
     * A rooms always has a room type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roomType()
    {
        return $this->belongsTo( RoomType::class, 'room_type_id', 'id' );
    }

}
