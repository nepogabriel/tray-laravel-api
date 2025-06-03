<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = Seller::all();
        
        if ($sellers->count() > 0) {
            foreach (range(1, 10) as $i) {
                Sale::factory()->create([
                    'seller_id' => $sellers->random()->id
                ]);
            }
        } else {
            Sale::factory(10)->create();
        }
    }
}
