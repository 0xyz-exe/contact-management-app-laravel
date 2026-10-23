<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'company', 'job_title',
        'address', 'group', 'notes', 'is_favorite',
    ];

    protected function casts(): array
    {
        return ['is_favorite' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
