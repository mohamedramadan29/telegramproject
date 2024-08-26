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
            'trader' => $this->faker->numerify('#####'),
            'country' => $this->faker->country(),
            'link-id' => $this->faker->numerify('#####'),
            'balance' => $this->faker->numberBetween(0, 999),
            'deposits' => $this->faker->numberBetween(0, 10),
            'deposits-sum' => $this->faker->numberBetween(0, 999),
            'withdrawals-count' => $this->faker->numberBetween(0, 10),
            'turnover-clear' => $this->faker->randomFloat(2, 0, 9999), // قيمة عشوائية مع دقة عشرية
            'vol-share' => $this->faker->randomFloat(2, 0, 9999),
        ];
    }
}
