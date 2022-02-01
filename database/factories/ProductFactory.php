<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id'=>$this->faker->numberBetween(1,5),
            'title'=>$this->faker->title,
            'description'=>$this->faker->paragraph,
            'img'=>$this->faker->imageUrl
        ];
    }
}
