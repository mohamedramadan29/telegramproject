<?php

namespace Database\Factories\admin;

use App\Models\admin\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{

    protected $model = Transaction::class;
    public function definition(): array
    {
        return [
            'trader-id' => $this->faker->numerify('#####'),
            'country' => $this->faker->country(),
            'balance' => $this->faker->numberBetween(0, 999),
            'deposits-count' => $this->faker->numberBetween(0, 10),
            'deposits-sum' => $this->faker->numberBetween(0, 999),
            'withdrawals-count' => $this->faker->numberBetween(0, 10),
            'withdrawals-sum' => $this->faker->numberBetween(0, 999),
            'turnover-clear' => $this->faker->randomFloat(2, 0, 9999), // قيمة عشوائية مع دقة عشرية
            'vol-share' => $this->faker->randomFloat(2, 0, 9999),
            'is-closed'=> $this->faker->randomElement([1,0]),
            'registery-date'=>date('Y-m-d'),
        ];
    }
}
