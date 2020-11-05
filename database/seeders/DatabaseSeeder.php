<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use Dcat\Admin\Models\AdminTablesSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\User::factory(10)->create();
//        // 单独处理第一个用户的数据
//        $user = User::find(1);
//        $user->name = 'yishui';
//        $user->email = '123@qq.com';
//        $user->password = Hash::make("123456");
//        $user->avatar = 'https://cdn.learnku.com/uploads/avatars/23459_1551926778.jpeg!/both/400x400';
//        $user->save();
//
//        // 填充admin表
//        $userModel = config('admin.database.users_model');
//        if ($userModel::count() == 0) {
//            $this->call(AdminTablesSeeder::class);
//        }
//
//        Post::factory(20)->create();
        Reply::factory(100)->create();
    }
}
