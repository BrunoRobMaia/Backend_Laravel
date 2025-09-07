<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'youtube_url',
        'user_id',
        'status', // optional: if you want to allow mass assignment for status too
    ];

    // Your existing relationships and methods...
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
