<?php

namespace App\Policies;

use Illuminate\Contracts\Auth\Authenticatable;

class CompanyPermissionPolicy
{
    public function isAllowCompanyPermission(Authenticatable $user, $companyRoleSlug)
    {
        return $user->checkCompanyPermission($companyRoleSlug);
    }
}
