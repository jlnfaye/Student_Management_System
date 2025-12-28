<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
    'student_id_number', // <--- Ensure this is here
    'name',
    'email',
    'age',
    'birthday',
    'address',
    'class_id',
    'student_photo',
];

    // This tells Laravel to treat birthday as a real date, not just text
    protected $casts = [
        'birthday' => 'date',
    ];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}