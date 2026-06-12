<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditService
{
    /**
     * Enregistre une action dans le journal d'audit.
     *
     * @param string   $action     Action effectuée (create|update|delete|login|logout|import)
     * @param string   $entityType Type d'entité concernée (vehicle|lead|user)
     * @param int|null $entityId   ID de l'entité concernée
     */
    public static function log(string $action, string $entityType, ?int $entityId = null): void
    {
        AuditLog::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'entity_type' => $entityType,
            'entity_id'  => $entityId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
