<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuggestionTest extends TestCase
{
  use RefreshDatabase;

  public function it_can_create_a_suggestion()
  {
    $user = User::factory()->create();

    $suggestion = Suggestion::create([
      'youtube_url' => 'https://youtube.com/watch?v=suggestion123',
      'user_id' => $user->id,
      'status' => 'pending'
    ]);

    $this->assertDatabaseHas('suggestions', [
      'youtube_url' => 'https://youtube.com/watch?v=suggestion123',
      'user_id' => $user->id,
      'status' => 'pending'
    ]);
  }

  public function it_belongs_to_a_user()
  {
    $user = User::factory()->create();
    $suggestion = Suggestion::create([
      'youtube_url' => 'https://youtube.com/watch?v=test',
      'user_id' => $user->id,
      'status' => 'pending'
    ]);

    $this->assertInstanceOf(User::class, $suggestion->user);
    $this->assertEquals($user->id, $suggestion->user->id);
  }

  public function it_can_be_approved()
  {
    $suggestion = Suggestion::create([
      'youtube_url' => 'https://youtube.com/watch?v=test',
      'user_id' => User::factory()->create()->id,
      'status' => 'pending'
    ]);

    $suggestion->update(['status' => 'approved']);

    $this->assertEquals('approved', $suggestion->fresh()->status);
  }

  public function it_can_be_rejected()
  {
    $suggestion = Suggestion::create([
      'youtube_url' => 'https://youtube.com/watch?v=test',
      'user_id' => User::factory()->create()->id,
      'status' => 'pending'
    ]);

    $suggestion->update(['status' => 'rejected']);

    $this->assertEquals('rejected', $suggestion->fresh()->status);
  }
}
