<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\CompanyPermission;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'sqlsrv3';
    protected $table = 'tblDIMSUSERS';
    protected $primaryKey = 'UserID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'UserName', 'Password', 'strField6',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'Password' => 'hashed',
    ];

    protected $companyPermissions = [];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->strField6;
    }

    /**
     * This function is used for check the company permission
     * @param string $companyRoleSlug
     */
    public function checkCompanyPermission($companyRoleSlug)
    {
        if (!$this->companyPermissions) {
            $this->companyPermissions = CompanyPermission::where('intCompanyId', 0)
                ->where('bitActive', 1)
                ->join('tblCompanyRoles', 'tblCompanyRoles.intAutoId', '=', 'tblCompanyPermissions.intCompanyRoleId')
                ->select('tblCompanyRoles.strSlug', 'tblCompanyPermissions.bitActive')
                ->pluck('bitActive', 'strSlug')
                ->toArray();
        }

        if (isset($this->companyPermissions[$companyRoleSlug]) && $this->companyPermissions[$companyRoleSlug] == 1) {
            return true;
        }

        return false;
    }
}
