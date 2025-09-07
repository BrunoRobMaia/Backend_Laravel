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

    public function topSongs(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $songs = Song::orderBy('play_count', 'desc')
            ->paginate($perPage);

        return response()->json([
            'data' => $songs->items(),
            'total' => $songs->total(),
            'page' => $songs->currentPage(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'youtube_url' => 'required|url',
            'play_count' => 'required|integer',
        ]);

        return Song::create($validated);
    }

    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'youtube_url' => 'sometimes|url',
            'play_count' => 'sometimes|integer',
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
