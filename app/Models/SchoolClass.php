<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model  // renamed
{
    use HasFactory;
    protected $table = 'classes';
    protected $fillable = ['name', 'section'];
}