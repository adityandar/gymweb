<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GymClass extends Model
{
    protected $fillable = ['name', 'trainer_id', 'schedule', 'capacity'];

    protected $table = 'gym_classes';

    protected function casts(): array
    {
        return ['schedule' => 'datetime'];
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'class_id');
    }

    public function bookedCount(): int
    {
        return $this->bookings()->where('status', 'booked')->count();
    }
}
