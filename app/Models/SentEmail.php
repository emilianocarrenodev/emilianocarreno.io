<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SentEmail extends Model
{
    protected $fillable = ['email'];

    public function openTrackings(): HasMany
    {
        return $this->hasMany(EmailOpenTracking::class);
    }

    public function recordOpenTracking(string $channel): EmailOpenTracking
    {
        return $this->openTrackings()->create([
            'channel' => $channel,
            'tracking_token' => (string) Str::uuid(),
        ]);
    }
}
