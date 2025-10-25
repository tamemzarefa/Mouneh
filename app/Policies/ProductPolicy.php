<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function create(?User $user): bool
    {
        return (bool)$user; // any authenticated user can create a listing
    }

    public function update(User $user, Product $product): bool
    {
        return (int)$user->id === (int)$product->seller_id || $this->isAdmin($user);
    }

    public function delete(User $user, Product $product): bool
    {
        return (int)$user->id === (int)$product->seller_id || $this->isAdmin($user);
    }

    public function approve(User $user, Product $product): bool
    {
        return $this->isAdmin($user);
    }

    public function reject(User $user, Product $product): bool
    {
        return $this->isAdmin($user);
    }

    private function isAdmin(User $user): bool
    {
        // Works if there's an is_admin column/cast; otherwise returns false.
        return (bool)($user->is_admin ?? false);
    }
}
