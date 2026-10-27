<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailOpenTracking extends Model
{
    protected $fillable = ['channel', 'tracking_token'];

    protected $hidden = ['tracking_token'];

    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
        ];
    }

    public function sentEmail(): BelongsTo
    {
        return $this->belongsTo(SentEmail::class);
    }
}
