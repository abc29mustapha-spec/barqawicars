<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Table immuable : un consentement ne peut pas être modifié, seulement créé
class Consent extends Model
{
    public $timestamps = false;

    protected $fillable = ['lead_id', 'consent_type', 'ip_address', 'user_agent', 'consented_at'];

    protected $casts = [
        'consented_at' => 'datetime',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
