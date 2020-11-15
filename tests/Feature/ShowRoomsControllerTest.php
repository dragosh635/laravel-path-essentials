<?php

namespace Tests\Feature;

use App\Models\RoomType;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ShowRoomsControllerTest extends TestCase {

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample() {
        $response = $this->get( '/rooms' );

        $response->assertStatus( 200 )
                 ->assertSeeText( 'Type' )
                 ->assertViewIs( 'rooms.index' )
                 ->assertViewHas( 'rooms' );
    }

    public function testRoomParameter() {
        $roomTypes = RoomType::factory()->count( 5 )->create();
        $rooms     = Room::factory()->count( 20 )->create();
        $roomType  = $roomTypes->random();

        $response = $this->get( '/rooms/' . $roomType->id );

        $response->assertStatus( 200 )
                 ->assertSeeText( 'Type' )
                 ->assertViewIs( 'rooms.index' )
                 ->assertViewHas( 'rooms' )
                 ->assertSeeText( $roomType->name );

    }

    public function testUpdateFile() {
        // fake a file to upload
        $file     = UploadedFile::fake()->image( 'sample.jpg' );

        // create a room type
        $roomType = RoomType::factory()->create();

        // submit the form passing the recently created fake image
        $response = $this->put( "/room_types/{$roomType->id}", [
            'picture' => $file,
        ] );

        // check the response
        $response->assertStatus( 302 )
                 ->assertRedirect( '/room_types' );

        // check that the file was saved at the specified location
        Storage::disk( 'public' )->assertExists( $file->hashName() );

    }
}
