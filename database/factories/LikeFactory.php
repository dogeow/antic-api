<?php

namespace Database\Factories;

use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'sub_header' => $this->faker->title,
            'img' => $this->faker->imageUrl(),
            'intro' => $this->faker->text,
            'link' => $this->faker->url,
            'feeling' => $this->faker->text,
        ];
    }
}
