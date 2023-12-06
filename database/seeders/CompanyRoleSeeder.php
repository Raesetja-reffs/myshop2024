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
            'Dispatch' => [
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Route Optomo',
                    'strSlug' => 'isallowrouteoptomo',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Drivers Report',
                    'strSlug' => 'isallowdriversreport',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Logistics Plan',
                    'strSlug' => 'isallowlogisticsplan',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow ImoveIt PODs',
                    'strSlug' => 'isallowimoveitpod',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Delivery Current Stats',
                    'strSlug' => 'isallowdeliverycurrentstats',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Number of Deliveries',
                    'strSlug' => 'isallownumberofdeliveries',
                    'strDescription' => '',
                ],
            ],
            'E-Commerce' => [
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow E-Commerce',
                    'strSlug' => 'isallowecommerce',
                    'strDescription' => '',
                ],
            ],
            'Sales' => [
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Awaiting Orders',
                    'strSlug' => 'isallowawaitingorders',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Awaiting Products',
                    'strSlug' => 'isallowawaitingproducts',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Remote Orders',
                    'strSlug' => 'isallowremoteorders',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Customer Sales Trend',
                    'strSlug' => 'isallowcustomersalestrend',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow IsellIt',
                    'strSlug' => 'isallowisellit',
                    'strDescription' => '',
                ],
            ],
            'Under Specials' => [
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Overall Specials',
                    'strSlug' => 'isallowoverallspecials',
                    'strDescription' => '',
                ],
            ],
            'Warehouse' => [
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Driver BI Report',
                    'strSlug' => 'isallowdriverbireport',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Qty Adj Picking',
                    'strSlug' => 'isallowqtyadjpicking',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Qty Adj Stage',
                    'strSlug' => 'isallowqtyadjstage',
                    'strDescription' => '',
                ],
                [
                    'strPermissionAbv' => '',
                    'strPermissionName' => 'Is Allow Transfers',
                    'strSlug' => 'isallowtransfers',
                    'strDescription' => '',
                ],
            ],
        ];

        foreach ($companyRoles as $name => $group) {
            foreach ($group as $companyRole) {
                $companyRole['strGroupName'] = $name;
                CompanyRole::create($companyRole);
            }
        }
    }
}
