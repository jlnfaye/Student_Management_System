<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'age',
        'class_id',
        'birthday',
        'address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthday' => 'date',
    ];

    /**
     * Get the class that the student belongs to.
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the student's formatted birthday.
     *
     * @return string|null
     */
    public function getFormattedBirthdayAttribute(): ?string
    {
        return $this->birthday ? $this->birthday->format('d M Y') : null;
    }

    /**
     * Get the student's age calculated from birthday (if available).
     *
     * @return int|null
     */
    public function getCalculatedAgeAttribute(): ?int
    {
        if (!$this->birthday) {
            return null;
        }

        return Carbon::parse($this->birthday)->age;
    }

    /**
     * Get the full name with ID (for display purposes).
     *
     * @return string
     */
    public function getFullNameWithIdAttribute(): string
    {
        return "#{$this->id} - {$this->name}";
    }
}