<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;

class AttendanceService
{
    public function generateQrToken(User $user): string
    {
        $data = json_encode([
            'user_id' => $user->id,
            'timestamp' => now()->timestamp,
            'expires' => now()->addSeconds(60)->timestamp,
        ]);

        return base64_encode($data);
    }

    public function validateAndRecord(string $token): ?Attendance
    {
        $data = json_decode(base64_decode($token), true);

        if (! $data || ! isset($data['user_id'], $data['expires'])) {
            return null;
        }

        if (now()->timestamp > $data['expires']) {
            return null;
        }

        $user = User::find($data['user_id']);
        if (! $user || ! $user->hasRole('member')) {
            return null;
        }

        $today = now()->toDateString();
        $alreadyCheckedIn = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->exists();

        if ($alreadyCheckedIn) {
            return null;
        }

        return Attendance::create([
            'user_id' => $user->id,
            'check_in_time' => now(),
            'date' => $today,
        ]);
    }
}
