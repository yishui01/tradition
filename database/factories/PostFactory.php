<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        $sentence = $faker->sentence();

        // 随机取一个月以内的时间
        $updated_at = $faker->dateTimeThisMonth();

        // 为创建时间传参，意为最大不超过 $updated_at，因为创建时间需永远比更改时间要早
        $created_at = $faker->dateTimeThisMonth($updated_at);

        return [
            'title'       => $sentence,
            'url'         => $faker->sentence,
            'author'      => $faker->name,
            'content'     => $faker->text(),
            'post_date'   => $faker->dateTime(),
            'view_count'  => mt_rand(10, 10000),
            'nice_count'  => mt_rand(10, 10000),
            'order'       => mt_rand(10, 10000),
            'excerpt'     => $sentence,
            'user_id'     => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'category_id' => $faker->randomElement([1, 2, 3, 4]),
            'created_at'  => $created_at,
            'updated_at'  => $updated_at,
        ];
    }
}
