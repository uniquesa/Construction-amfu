<?php

namespace App\Policies;

use App\Models\Approval;
use App\Models\User;

class ApprovalPolicy
{
    /**
     * Check if user can approve/reject this approval step
     */
    public function act(User $user, Approval $approval)
    {
        // Mapping approval levels to roles
        $roleMap = [
            'PM'  => 'Project Manager',
            'FCO' => 'Finance Control Officer',
            'PMO' => 'Project Management Officer',
            'CSO' => 'Chief Strategy Officer',
        ];

        $requiredRole = $roleMap[$approval->level] ?? null;

        if (!$requiredRole) {
            return false;
        }

        return $user->hasRole($requiredRole) && $approval->status === 'Pending';
    }
}
