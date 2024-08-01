<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPermission extends Model
{
    use HasFactory;
    protected $table = 'tblCompanyPermissions';
    protected $primaryKey = 'intAutoId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'intCompanyRoleId',
        'strCompanyId',
        'bitActive',
    ];
}
