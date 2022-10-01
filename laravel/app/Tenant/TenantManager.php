<?php

declare(strict_types=1);

namespace App\Tenant;

use App\Enum\ValidRoles;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Support\Facades\Auth;

class TenantManager
{
    private int $tenant;
    private ?User $user = NULL;
    private ?bool $isAdmin = NULL;
    private ?bool $isCompany = NULL;
    private ?bool $isClient = NULL;

    public function setTenant(int $id): void
    {
        $this->tenant = $id;
    }

    public function getTenant(): int
    {

        return $this->tenant;
    }

    public function getUser(): User
    {
        if ($this->user) return $this->user;
        $this->user = Auth::guard('api')->user();
        return $this->user;
    }

    public function isAdmin(): bool
    {
        if ($this->isAdmin === null)
            $this->isAdmin = RoleService::verifyRolesByEmail($this->getUser()->email, ValidRoles::ADMIN);

        return $this->isAdmin;
    }

    public function isCompany(): bool
    {
        if ($this->isCompany === null)
            $this->isCompany = RoleService::verifyRolesByEmail($this->getUser()->email, ValidRoles::COMPANY);

        return $this->isCompany;
    }

    public function isClient(): bool
    {
        if ($this->isClient === null)
            $this->isClient = RoleService::verifyRolesByEmail($this->getUser()->email, ValidRoles::CLIENT);

        return $this->isClient;
    }
}
