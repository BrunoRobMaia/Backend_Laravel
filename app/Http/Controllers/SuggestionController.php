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

    public function suggestions(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $suggestions = Suggestion::orderBy('created_at', 'desc')
            ->with('user') // 👈 se quiser trazer o relacionamento
            ->paginate($perPage);

        return response()->json([
            'data' => $suggestions->items(),
            'total' => $suggestions->total(),
            'page' => $suggestions->currentPage(),
        ]);
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
