<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'youtube_url' => 'https://youtu.be/' . $this->faker->unique()->regexify('[A-Za-z0-9]{11}'),
            'play_count' => $this->faker->numberBetween(0, 99999999),
        ];
    }
}
