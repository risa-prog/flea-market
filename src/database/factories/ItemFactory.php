<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>\App\Models\User::factory(),
            'category_id'=>$this->faker->numberBetween(1,14),
            'item_name' => $this->faker->name,
            'item_image' => $this->faker->text(),
            'price'=>$this->faker->randomNumber(),
            'description'=>$this->faker->realText(),
            'condition'=>$this->faker->numberBetween(1,4),
        ];
    }
}
