<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $priceArr = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        return [
            //
            'name'=>$this->faker->word(),
            'price'=>$this->faker->randomElement($priceArr),
            'qty'=>$this->faker->randomElement($priceArr),
            'description'=>$this->faker->sentence
        ];
    }
}
