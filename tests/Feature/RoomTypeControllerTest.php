<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class RoomTypeControllerTest extends TestCase {
    /**
     * A basic feature test example.
     * Test view room types action along the cache part
     *
     * @return void
     */
    public function testExample() {
        /* Mock class for cache */
        Cache::shouldReceive( 'get' )
             ->once()
             ->with( 'key' )
             ->andReturn( 'value' );

        $response = $this->get( '/room_types' );

        $response->assertStatus( 200 )
                 ->assertSeeText( 'Name' )
                 ->assertViewIs( 'roomTypes.index' );
    }
}
