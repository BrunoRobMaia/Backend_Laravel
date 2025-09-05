<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        return Song::all();
    }

    public function topSongs()
    {
        return Song::orderBy('play_count', 'desc')->take(5)->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'youtube_url' => 'required|url'
        ]);

        return Song::create($validated);
    }

    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'youtube_url' => 'sometimes|url'
        ]);

        $song->update($validated);
        return $song;
    }

    public function destroy(Song $song)
    {
        $song->delete();
        return response()->noContent();
    }
}