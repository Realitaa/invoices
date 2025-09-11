<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa user untuk relasi
        User::factory()->count(5)->create();

        // Buat 20 data transaksi dummy
        Transaction::factory()->count(20)->create();
    }
}
