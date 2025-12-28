<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // --- THIS IS THE MISSING PART ---
    // Without this list, Laravel blocks the data from being saved!
    protected $fillable = [
        'user_id', 
        'action', 
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}