<?php

namespace Tests\Unit;

use App\Console\Commands\EmailReservationsCommand;
use App\Libraries\Notifications;
use PHPUnit\Framework\TestCase;

class EmailReservationsCommandTest extends TestCase {
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample() {
        $notify = $this->getMockBuilder( Notifications::class )
                       ->disableOriginalConstructor()
                       ->onlyMethods( [ 'send' ] )
                       ->getMock();

        $notify->expects( $this->once() )
               ->method( 'send' )
               ->with()
               ->willReturn( true );

        $command = $this->getMockBuilder( EmailReservationsCommand::class )
                        ->setConstructorArgs( [ $notify ] )
                        ->onlyMethods( [ 'option' ] )
                        ->getMock();

        $command->expects( $this->once() )
                ->method( 'option' )
                ->with( 'dry-run' )
                ->willReturn( false );

        $command->processBooking();
    }
}
