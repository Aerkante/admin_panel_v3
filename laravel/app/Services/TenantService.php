<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;

class TenantService
{
    /**
     * return tenant by user id
     *
     * @param integer $id
     * @return Company
     */
    static function getTenantByUserId(int $id): Company
    {
        // tenant
        $tenant = Company::whereHas('users', function ($builder) use ($id) {
            $builder->where('users.id', $id);
        })->first();



        if ($tenant) return $tenant;
    }
}
