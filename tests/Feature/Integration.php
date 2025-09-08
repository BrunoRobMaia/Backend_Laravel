<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Song;
use App\Models\Suggestion;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IntegrationTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function user_can_create_song_and_suggestion()
  {
    $user = User::factory()->create();

    // Create a song
    $song = Song::create([
      'title' => 'Integration Song',
      'artist' => 'Integration Artist',
      'url' => 'https://example.com/integration.mp3',
      'user_id' => $user->id
    ]);

    // Create a suggestion
    $suggestion = Suggestion::create([
      'title' => 'Integration Suggestion',
      'artist' => 'Integration Artist',
      'message' => 'This is an integration test',
      'user_id' => $user->id,
      'status' => 'pending'
    ]);

    // Verify all relationships
    $this->assertEquals($user->id, $song->user_id);
    $this->assertEquals($user->id, $suggestion->user_id);
    $this->assertCount(1, $user->songs);
    $this->assertCount(1, $user->suggestions);
  }
}
