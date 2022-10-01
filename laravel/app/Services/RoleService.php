<?php

namespace App\Services;

use App\Enum\ValidRoles;
use App\Exceptions\RoleNotFound;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleService
{
    /**
     * Returns id of role find by slug
     *
     * @param ValidRoles $slug
     * @return int
     */
    static function findSlug($slug): int
    {
        try {
            $role = Role::where('slug', $slug)->firstOrFail(['id']);
            return $role->id;
        } catch (\Throwable $th) {
            throw new RoleNotFound();
        }
    }

    static function verifyRolesByEmail(string $email, ...$roles)
    {
        $hasRole = User::where('email', $email)->whereHas('roles', function ($builder) use ($roles) {
            $builder->whereIn('slug', $roles);
        })->count() > 0;
        return $hasRole;
    }

    /**
     * Verify if logged user has admin role
     *@return bool
     */
    static function verifyIsAdmin(): bool
    {
        $userId = Auth::user()->id;
        if (!$userId) return false;
        $isAdmin = User::where('id', $userId)->whereHas(
            'roles',
            fn ($builder) => $builder->where('slug', 'admin')
        )->count() > 0;

        return $isAdmin;
    }
}
