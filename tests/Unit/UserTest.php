<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_can_create_a_user()
  {
    $user = User::factory()->create([
      'name' => 'Test User',
      'email' => 'test@example.com'
    ]);

    $this->assertDatabaseHas('users', [
      'email' => 'test@example.com'
    ]);
  }

  /** @test */
  public function it_can_update_a_user()
  {
    $user = User::factory()->create();

    $user->update(['name' => 'Updated Name']);

    $this->assertEquals('Updated Name', $user->fresh()->name);
  }
}
