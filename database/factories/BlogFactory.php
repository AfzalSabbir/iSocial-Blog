<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name_arr = $this->faker->words(rand(7, 12));
        $name     = implode(' ', $name_arr);
        $tag      = implode(',', $name_arr);

        $body = implode(' ', $this->faker->words(rand(200, 300)));
        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'banner'      => '/storage/uploads/blog-' . rand(1, 3) . '.jpg',
            'body'        => $body,
            'category_id' => rand(1, Category::query()->count()),
            'tag'         => $tag,
        ];
    }
}
