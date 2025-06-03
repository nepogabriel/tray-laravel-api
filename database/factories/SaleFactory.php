<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Seller;
use App\Services\SaleService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $value = $this->faker->randomFloat(2, 100, 5000);
        $commission = $value * (SaleService::COMMISSION / 100); 

        return [
            'seller_id' => Seller::factory(),
            'value' => $value,
            'commission' => $commission,
            'sale_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
