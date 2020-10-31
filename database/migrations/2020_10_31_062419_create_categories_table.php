<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->default(0);
            $table->integer("order")->default(0);
            $table->string("title");
            $table->string("introduction")->default("");
            $table->timestamps();
        });
        $categories = [
            [
                'title'        => '分享',
                'introduction' => '分享创造，分享发现',
            ],
            [
                'title'        => '教程',
                'introduction' => '开发技巧、推荐扩展包等',
            ],
            [
                'title'        => '问答',
                'introduction' => '请保持友善，互帮互助',
            ],
            [
                'title'        => '公告',
                'introduction' => '站点公告',
            ],
        ];

        \Illuminate\Support\Facades\DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
