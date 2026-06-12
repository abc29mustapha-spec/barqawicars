<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id', 'model', 'version', 'vehicle_type', 'condition', 'seller_type',
        'year', 'mileage', 'price', 'price_type', 'seats', 'doors', 'sliding_door',
        'country', 'city',
        // Données techniques
        'fuel_type', 'power_hp', 'power_kw', 'cylinder', 'towing_capacity', 'weight',
        'drive', 'transmission', 'fuel_consumption', 'emission_standard', 'dpf',
        // Extérieur
        'exterior_color', 'tow_bar', 'parking_radar',
        // Intérieur
        'interior_color', 'interior_material', 'air_conditioning',
        // État / Historique
        'service_book', 'safety_compliant', 'warranty', 'full_service', 'non_smoker',
        'previous_owners', 'ct_valid_days',
        // Équipements JSON
        'exterior_extras', 'interior_extras',
        // Détails de l'offre
        'has_photos', 'has_video', 'export_available', 'is_demonstration',
        'is_collaborator', 'is_collection', 'vat_status', 'description',
        // VIN et statut
        'vin', 'status', 'ancien_prix',
    ];

    protected $casts = [
        'exterior_extras'   => 'array',
        'interior_extras'   => 'array',
        'dpf'               => 'boolean',
        'service_book'      => 'boolean',
        'safety_compliant'  => 'boolean',
        'warranty'          => 'boolean',
        'full_service'      => 'boolean',
        'non_smoker'        => 'boolean',
        'has_photos'        => 'boolean',
        'has_video'         => 'boolean',
        'export_available'  => 'boolean',
        'is_demonstration'  => 'boolean',
        'is_collaborator'   => 'boolean',
        'is_collection'     => 'boolean',
        'price'             => 'decimal:2',
        'ancien_prix'       => 'decimal:2',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // Toutes les images du véhicule
    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class)->orderBy('position');
    }

    // Image principale uniquement
    public function mainImage(): HasOne
    {
        return $this->hasOne(VehicleImage::class)->where('is_main', true);
    }

    // Leads associés à ce véhicule
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    // Nom complet : Marque + Modèle + Version
    public function getFullNameAttribute(): string
    {
        return trim("{$this->brand?->name} {$this->model} {$this->version}");
    }

    // Scope : uniquement les véhicules actifs
    public function scopeActif($query)
    {
        return $query->where('status', 'actif');
    }

    // Scope : véhicules disponibles à l'export
    public function scopeExportable($query)
    {
        return $query->where('export_available', true);
    }
}
