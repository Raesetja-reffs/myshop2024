<?php

namespace App\Policies;

use App\Models\CentralUser;

class CentralUserPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function index(CentralUser $centralUser): bool
    {
        if ($centralUser->user_role == 4) {

            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function create(CentralUser $centralUser): bool
    {
        if ($centralUser->user_role == 4) {

            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(CentralUser $centralUser, CentralUser $model): bool
    {
        return $this->isAdminCompanyMember($centralUser, $model);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(CentralUser $centralUser, CentralUser $model): bool
    {
        if ($model->user_role == 1) {// if admin user then don't allow to update

            return false;
        }

        return $this->isAdminCompanyMember($centralUser, $model);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(CentralUser $centralUser, CentralUser $model): bool
    {
        if ($model->user_role == 1) {// if admin user then don't allow to remove

            return false;
        }
        if ($centralUser->user_role == 1) {

            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function resetPassword(CentralUser $centralUser, CentralUser $model): bool
    {
        if ($centralUser->user_role != 1 && $model->user_role == 1) {// if admin user then don't allow to remove

            return false;
        }

        return $this->isAdminCompanyMember($centralUser, $model);
    }

    /**
     * This function is used check if logged in user is admin or user is member of company then allow
     */
    private function isAdminCompanyMember(CentralUser $centralUser, CentralUser $model): bool
    {
        if (in_array($centralUser->user_role, [1, 2])) {

            return true;
        }
        if ($centralUser->user_role == 3 && $centralUser->company_id == $model->company_id) {

            return true;
        }

        return false;
    }
}
