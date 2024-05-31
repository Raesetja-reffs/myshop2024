<?php

namespace Database\Seeders;

use App\Models\CentralUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CentralUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CentralUser::create([
            'username' => 'Admin',
            'password' => Hash::make('Admin@123'),
            'company_id' => 'Dims',
            'erp_user_id' => 1,
            'erp_apiurl' => '',
            'erp_apiusername' => '',
            'erp_apipassword' => '',
            'erp_apiauthtoken' => '',
            'location_id' => 1,
        ]);
    }
}
