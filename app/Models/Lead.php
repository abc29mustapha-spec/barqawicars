<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type', 'name', 'email', 'phone', 'country', 'message',
        'vehicle_id', 'current_status', 'assigned_to', 'anonymized_at',
    ];

    protected $casts = [
        'anonymized_at' => 'datetime',
    ];

    // Véhicule concerné par ce lead
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Commercial assigné à ce lead
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Historique des changements de statut
    public function statusHistory(): HasMany
    {
        return $this->hasMany(LeadStatusHistory::class)->orderByDesc('created_at');
    }

    // Consentements RGPD liés à ce lead
    public function consents(): HasMany
    {
        return $this->hasMany(Consent::class);
    }

    // Libellés lisibles pour les types de lead
    public static function typeLabels(): array
    {
        return [
            'contact'    => 'Contact général',
            'quote'      => 'Demande de devis',
            'test_drive' => 'Essai véhicule',
            'export'     => 'Demande export',
            'whatsapp'   => 'WhatsApp',
        ];
    }

    // Libellés lisibles pour les statuts
    public static function statusLabels(): array
    {
        return [
            'new'         => 'Nouveau',
            'in_progress' => 'En cours',
            'closed'      => 'Clôturé',
            'cancelled'   => 'Annulé',
        ];
    }

    // RGPD Art. 17 — remplace les données personnelles par des valeurs neutres
    // Opération irréversible : les données originales sont perdues définitivement
    public function anonymize(): void
    {
        if ($this->anonymized_at !== null) {
            return;
        }

        DB::transaction(function () {
            $this->update([
                'name'           => '[Anonymisé]',
                'email'          => 'anonymise@barqawi.invalid',
                'phone'          => null,
                'country'        => null,
                'message'        => null,
                'anonymized_at'  => now(),
            ]);

            // L'IP et le user-agent dans les consentements sont aussi des données personnelles
            $this->consents()->update([
                'ip_address' => '0.0.0.0',
                'user_agent' => null,
            ]);
        });
    }
}
