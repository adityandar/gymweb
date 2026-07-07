<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['payment_mode'];

    public static function paymentMode(): string
    {
        $setting = static::first();
        return $setting?->payment_mode ?? 'automatic';
    }

    public static function isAutomatic(): bool
    {
        return static::paymentMode() === 'automatic';
    }

    public static function isManual(): bool
    {
        return static::paymentMode() === 'manual';
    }
}
