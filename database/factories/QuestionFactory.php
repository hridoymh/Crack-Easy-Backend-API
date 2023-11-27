<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        return [
            'ownerid' => 11,
            'questionStatement' => $faker->sentence(5),
            'a' => $faker->word,
            'b' => $faker->word,
            'c' => $faker->word,
            'd' => $faker->word,
            'ans' => $faker->randomElement(['a','b','c','d'])

        ];
    }
}
