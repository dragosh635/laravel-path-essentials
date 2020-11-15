<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class HomeControllerTest extends TestCase {
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * Test login user action
     *
     * @return void
     */
    public function testExample() {
        $user     = User::factory()->create();
        $response = $this->actingAs( $user )->get( '/' );

        $response->assertStatus( 200 )
                 ->assertSeeText( 'Logout' );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoggedOut() {
        $response = $this->get( '/home' );

        $response->assertStatus( 302 )
                 ->assertRedirect( '/login' );
    }

}
