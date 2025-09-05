<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index()
    {
        return Suggestion::with('user')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'youtube_url' => 'required|url'
        ]);

        return Suggestion::create([
            'youtube_url' => $validated['youtube_url'],
            'user_id' => auth()->id()
        ]);
    }

    public function approve(Suggestion $suggestion)
    {
        $suggestion->update(['status' => 'approved']);
        return $suggestion;
    }

    public function reject(Suggestion $suggestion)
    {
        $suggestion->update(['status' => 'rejected']);
        return $suggestion;
    }

    public function destroy(Suggestion $suggestion)
    {
        $suggestion->delete();
        return response()->noContent();
    }
}