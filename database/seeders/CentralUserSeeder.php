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
            'is_admin' => 0,
            'username' => 'Admin',
            'password' => Hash::make('D!ms@pp_123#@!'),
            'company_id' => '5730aaa7-fd77-e46f-298d-e8eca042d6a9',
            'erp_user_id' => 1,
            'erp_apiurl' => 'https://linxsystems.flowgear.net/dims24/',
            'erp_apiusername' => '',
            'erp_apipassword' => '',
            'erp_apiauthtoken' => 'xKPL-wgePSBi_eQaLkxNkbFq3T39OPEm3ka7xZo3wYzPzzvTXWTjASi0ShYLyMOu8TE-OK-DtmQDeZZdMdxtxw',
            'location_id' => 1,
        ]);
    }
}
