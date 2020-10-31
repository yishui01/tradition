<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 头像假数据
        $avatars = [
            'https://file.wuxxin.com/tradition/x2.jpg',
            'https://file.wuxxin.com/tradition/x3.jpg',
            'https://file.wuxxin.com/tradition/m1.jpg',
            'https://file.wuxxin.com/tradition/l1.jpg',
        ];

        $faker = $this->faker;
        $date_time = $faker->date . ' ' . $faker->time;
        return [
            'name'              => $faker->name,
            'email'             => $faker->unique()->safeEmail,
            'remember_token'    => Str::random(10),
            'avatar'            => $faker->randomElement($avatars),
            'email_verified_at' => now(),
            'password'          => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'introduction'      => $faker->sentence(),
            'created_at'        => $date_time,
            'updated_at'        => $date_time,
        ];
    }
}
