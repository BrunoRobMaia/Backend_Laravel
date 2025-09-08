<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Song;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SongTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_can_create_a_song()
  {
    $song = Song::create([
      'title' => 'Test Song',
      'youtube_url' => 'https://youtube.com/watch?v=test123',
      'play_count' => 0
    ]);

    $this->assertDatabaseHas('songs', [
      'title' => 'Test Song',
      'youtube_url' => 'https://youtube.com/watch?v=test123',
      'play_count' => 0
    ]);
  }

  /** @test */
  public function it_can_update_a_song()
  {
    $song = Song::create([
      'title' => 'Original Title',
      'youtube_url' => 'https://youtube.com/watch?v=original',
      'play_count' => 10
    ]);

    $song->update([
      'title' => 'Updated Title',
      'play_count' => 20
    ]);

    $this->assertDatabaseHas('songs', [
      'title' => 'Updated Title',
      'play_count' => 20
    ]);
  }

  /** @test */
  public function it_can_increment_play_count()
  {
    $song = Song::create([
      'title' => 'Test Song',
      'youtube_url' => 'https://youtube.com/watch?v=test123',
      'play_count' => 5
    ]);

    $song->increment('play_count');

    $this->assertEquals(6, $song->fresh()->play_count);
  }

  /** @test */
  public function it_can_be_ordered_by_play_count()
  {
    Song::create(['title' => 'Song 1', 'youtube_url' => 'url1', 'play_count' => 10]);
    Song::create(['title' => 'Song 2', 'youtube_url' => 'url2', 'play_count' => 30]);
    Song::create(['title' => 'Song 3', 'youtube_url' => 'url3', 'play_count' => 20]);

    $topSongs = Song::orderBy('play_count', 'desc')->get();

    $this->assertEquals('Song 2', $topSongs[0]->title);
    $this->assertEquals('Song 3', $topSongs[1]->title);
    $this->assertEquals('Song 1', $topSongs[2]->title);
  }
}
