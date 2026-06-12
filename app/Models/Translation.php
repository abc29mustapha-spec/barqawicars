<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = ['entity_type', 'entity_id', 'locale', 'field', 'value'];

    // Récupère une traduction spécifique
    public static function getTranslation(
        string $entityType,
        int $entityId,
        string $locale,
        string $field
    ): ?string {
        return static::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('locale', $locale)
            ->where('field', $field)
            ->value('value');
    }

    // Enregistre ou met à jour une traduction
    public static function setTranslation(
        string $entityType,
        int $entityId,
        string $locale,
        string $field,
        string $value
    ): void {
        static::updateOrCreate(
            [
                'entity_type' => $entityType,
                'entity_id'   => $entityId,
                'locale'      => $locale,
                'field'       => $field,
            ],
            ['value' => $value]
        );
    }
}
