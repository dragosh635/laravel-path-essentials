<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use App\Libraries\Notifications;
use App\Notifications\Reservation;

class EmailReservationsCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:notify {count : The number of bookings to retrieve}{--dry-run= : To have this command do no actual work.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Reservations holders';

    /**
     * EmailReservationsCommand constructor.
     *
     * @param Notifications $notify
     */
    public function __construct( Notifications $notify ) {
        $this->notify = $notify;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $answer = $this->choice( 'What service should we use ?', [ 'sms', 'email' ], 'email' );

        $count = $this->argument( 'count' );
        if ( ! is_numeric( $count ) ) {
            $this->alert( 'The count must be a number' );

            return 1;
        }
        $bookings = Booking::with( [ 'room.roomType', 'users' ] )->limit( $count )->get();
        $this->info( sprintf( 'The number of bookings to alert for is: %d', $bookings->count() ) );

        $bar = $this->output->createProgressBar( $bookings->count() );
        $bar->start();
        foreach ( $bookings as $booking ) {
            $this->processBooking( $booking );
            $bar->advance();
        }
        $bar->finish();
        $this->comment( 'Command completed' );
    }

    /**
     * Process a single booking during the execution of the command
     *
     * @param Booking $booking
     */
    public function processBooking( $booking ) {
        if ( $this->option( 'dry-run' ) ) {
            $this->info( 'Would process booking' );
        } else {
            $booking->notify( new Reservation( 'Mart Martin' ) );
        }
    }
}
