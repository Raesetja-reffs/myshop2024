<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyRole;

class CompanyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyRoles = [
            [
                'strPermissionAbv' => '',
                'strPermissionName' => 'IsAllowGroupSpecials',
                'strSlug' => 'isallowgroupspecials',
                'strGroupName' => 'Specials',
                'strDescription' => '',
            ],
            [
                'strPermissionAbv' => '',
                'strPermissionName' => 'IsAllowOverallSpecials',
                'strSlug' => 'isallowoverallspecials',
                'strGroupName' => 'Specials',
                'strDescription' => '',
            ],
            [
                'strPermissionAbv' => '',
                'strPermissionName' => 'IsAllowPickingDashboard',
                'strSlug' => 'isallowpickingdashboard',
                'strGroupName' => 'Warehouse',
                'strDescription' => '',
            ],
            [
                'strPermissionAbv' => '',
                'strPermissionName' => 'IsAllowPickingTeam',
                'strSlug' => 'isallowpickingteam',
                'strGroupName' => 'Warehouse',
                'strDescription' => '',
            ],
            [
                'strPermissionAbv' => '',
                'strPermissionName' => 'IsAllowOrderListing',
                'strSlug' => 'isalloworderlisting',
                'strGroupName' => 'General',
                'strDescription' => '',
            ],
            [
                'strPermissionAbv' => '',
                'strPermissionName' => 'IsAllowPriceCheck',
                'strSlug' => 'isallowpricecheck',
                'strGroupName' => 'General',
                'strDescription' => '',
            ],
            [
                'strPermissionAbv' => '',
                'strPermissionName' => 'IsAllowOnOrder',
                'strSlug' => 'isallowonorder',
                'strGroupName' => 'General',
                'strDescription' => '',
            ]
        ];

        foreach ($companyRoles as $companyRole) {
            CompanyRole::create($companyRole);
        }
    }
}
