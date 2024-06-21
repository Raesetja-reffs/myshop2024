<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CentralUser extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'company_id',
        'erp_user_id',
        'erp_user_id',
        'erp_apiurl',
        'erp_apiusername',
        'erp_apipassword',
        'erp_apiauthtoken',
        'location_id',
    ];
}
