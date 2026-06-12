<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Table immuable : seulement created_at, pas de updated_at
class LeadStatusHistory extends Model
{
    protected $table = 'lead_status_history';

    public $timestamps = false;

    protected $fillable = ['lead_id', 'status', 'comment', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
