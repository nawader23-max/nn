<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsentRecord extends Model
{
    protected $fillable = [
        'user_id', 'purpose', 'policy_version', 'fingerprint',
        'ip_address', 'user_agent', 'accepted_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];
}
