<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $comment_arr = $this->faker->words(rand(30, 50));
        $comment     = implode(' ', $comment_arr);

        return [
            'blog_id' => rand(1, Blog::query()->count()),
            'comment' => $comment,
        ];
    }
}
