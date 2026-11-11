<?php

namespace Database\Factories;

use App\Models\review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'book_id' => null,
            'reviews' => fake()->paragraph(),
            'ratings' => fake()->numberBetween(1, 5),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => function(array $attributes){
                return fake()->dateTimeBetween($attributes['created_at']);
            },

        ];
    }

    public function goodReview(){
        return $this->state(function(array $attributes){
            return [
                'ratings' => fake()->numberBetween(4,5)
            ];
        });
    }

    public function avgReview(){
        return $this->state(function(array $attributes){
            return [
                'ratings' => fake()->numberBetween(2,3)
            ];
        });
    }


    public function badReview(){
        return $this->state(function(array $attributes){
            return [
                'ratings' => fake()->numberBetween(1,2)
            ];
        });
    }



}
