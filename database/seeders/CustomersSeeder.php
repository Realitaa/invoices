<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->create([
            'id_number' => '4843808',
            'account_name' => 'BANK ACEH SYARIAH',
            'npwp_trems' => '01.128.745.5-101.000',
            'address' => 'JL. M. Hasan - Batoh
Banda Aceh
00000',
            'ubis' => 'Test Data',
            'bisnis_area' => 'Test Data',
            'business_share' => 'Test Data',
            'divisi' => 'Test Data',
            'witel' => 'Test Data',
        ]);

        Customer::factory()->create([
            'id_number' => '4854211',
            'account_name' => 'POLDA ACEH',
            'npwp_trems' => '001420868101000',
            'address' => 'JALAN T.NYAK ARIEF, JEULINGKE, BANDA ACEH',
            'ubis' => 'Test Data',
            'bisnis_area' => 'Test Data',
            'business_share' => 'Test Data',
            'divisi' => 'Test Data',
            'witel' => 'Test Data',
        ]);
    }
}
