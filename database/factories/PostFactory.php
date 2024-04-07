<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $users = User::get();
        return [
            'theme' => $this->faker->sentence,
            'text' => $this->faker->paragraph,
            'blocked' => 0,
            'category_id' => $this->faker->randomElement([1, 2]),
            'author_id' => $this->faker->randomElement($users)->id,
        ];
    }
}
