<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    // Peut modifier un lead (statut, assignation) ?
    public function update(User $user, Lead $lead): bool
    {
        return $user->isAdmin() || $lead->assigned_to === $user->id;
    }

    // Peut supprimer un lead ?
    public function delete(User $user, Lead $lead): bool
    {
        return $user->isAdmin() || $lead->assigned_to === $user->id;
    }

    // Peut anonymiser un lead (RGPD Art. 17) ? — admin uniquement
    public function anonymize(User $user, Lead $lead): bool
    {
        return $user->isAdmin();
    }
}
