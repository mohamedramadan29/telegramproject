<?php

namespace Database\Seeders;

use App\Models\admin\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       factory(Transaction::class,10)->create();
    }
}
