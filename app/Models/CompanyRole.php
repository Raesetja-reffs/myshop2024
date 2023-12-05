<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRole extends Model
{
    use HasFactory;
    protected $table = 'tblCompanyRoles';
    protected $primaryKey = 'intAutoId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'strPermissionAbv',
        'strPermissionName',
        'strSlug',
        'strGroupName',
        'strDescription',
    ];
}
