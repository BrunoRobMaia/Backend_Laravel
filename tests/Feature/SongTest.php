<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Song;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class SongTest extends TestCase
{
    public function test_can_get_top_songs()
    {
        // Criar 10 músicas manualmente (já que a factory pode não estar funcionando ainda)
        for ($i = 0; $i < 10; $i++) {
            Song::create([
                'title' => 'Song ' . $i,
                'youtube_url' => 'https://youtu.be/test' . $i,
                'play_count' => 100 - $i
            ]);
        }
        
        $response = $this->getJson('/api/top-songs');
        
        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_authenticated_user_can_create_song()
    {
        // Criar usuário manualmente
        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password123')
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/songs', [
            'title' => 'Test Song',
            'youtube_url' => 'https://www.youtube.com/watch?v=YQHcAQaC6EU&list=PLdqdRjPNmhNAumj8At-Fn-CGY9hreuKwN&index=1'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('songs', ['title' => 'Test Song']);
    }
}