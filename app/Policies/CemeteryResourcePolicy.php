<?php

namespace App\Policies;

use App\Models\User;

class CemeteryResourcePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Semi Admin', 'Cashier', 'Staff', 'Guard', 'Collector', 'Family']);
    }

    public function view(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Semi Admin', 'Cashier', 'Collector']);
    }

    public function update(User $user): bool
    {
        return $user->hasRole('Semi Admin');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('Semi Admin');
    }

    public function approve(User $user): bool
    {
        return $user->hasRole('Semi Admin');
    }

    public function collectPayment(User $user): bool
    {
        return $user->hasAnyRole(['Cashier', 'Collector']);
    }
}
