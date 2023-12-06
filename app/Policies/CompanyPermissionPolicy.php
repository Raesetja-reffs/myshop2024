<?php

namespace App\Policies;

use App\Models\User;

class CompanyPermissionPolicy
{
    public function isAllowCompanyPermission(User $user, $companyRoleSlug)
    {
        return $user->checkCompanyPermission($companyRoleSlug);
    }
}
