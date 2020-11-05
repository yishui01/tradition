<?php

namespace Database\Factories;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        // 随机取一个月以内的时间
        $time = $faker->dateTimeThisMonth();
        return [
            'content'    => $faker->sentence(),
            'created_at' => $time,
            'updated_at' => $time,
            'post_id'    => rand(1, 100),
            'parent_id'  => rand(1, 100),
            'user_id'    => rand(1, 10),
            'path'       => ''
        ];
    }
}
