<?php

namespace App\Services;

use App\Models\Company;



class CompanyService
{
    /**
     * return company by user id
     *
     * @param integer $id
     * @return Company
     */
    static function getCompanyByUserId(int $id, array $columns = []): Company
    {
        $company = Company::whereHas('users', function ($builder) use ($id) {
            $builder->where('users.id', $id);
        });
        if (sizeof($columns) > 0)
            $company = $company->select($columns);

        return $company->first();
    }
}
