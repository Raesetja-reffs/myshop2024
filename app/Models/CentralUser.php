<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UtilityTrait;

class CentralUser extends Authenticatable
{
    use HasFactory, Notifiable, UtilityTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_role',
        'username',
        'password',
        'company_id',
        'erp_user_id',
        'erp_apiurl',
        'erp_apiusername',
        'erp_apipassword',
        'erp_apiauthtoken',
        'location_id',
        'internal_pass',
        'company_name',
    ];

    /**
     * This function is used for check the user is admin or not
     */
    public function isSuperAdmin()
    {
        return $this->user_role == '1';
    }
}
