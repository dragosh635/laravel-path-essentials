<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reservations extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Reservations constructor.
     * Create a new message instance.
     *
     * @param string $name
     */
    public function __construct( string $name = '' ) {
        $this->name = $name;
    }

    /**
     * Build the message / mail.
     *
     * @return $this
     */
    public function build() {
        return $this->markdown( 'email.reservation' )
                    ->with( [
                        'name' => $this->name,
                    ] );
    }
}
