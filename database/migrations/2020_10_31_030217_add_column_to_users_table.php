<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->comment("手机号");
            $table->string('avatar')->nullable();
            $table->string('introduction')->nullable();
            $table->integer('click')->default(0)->comment("用户信息查看次数");
            $table->string('wx_openid')->nullable()->comment("微信公众号openid");
            $table->string('wx_pc_openid')->nullable()->comment("微信PC扫码openid");
            $table->string('wx_union_id')->nullable()->comment("微信union_id");
            $table->json('wx_info')->nullable()->comment("微信授权个人信息json");
            $table->dateTime('last_actived_at')->nullable()->comment("最后活跃时间");
            $table->integer('fans_count')->default(0)->comment("拥有的粉丝数");
            $table->integer('follow_count')->default(0)->comment("关注人数");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                "phone",
                "avatar",
                "introduction",
                "click",
                "wx_openid",
                "wx_pc_openid",
                "wx_union_id",
                "wx_info",
                "last_actived_at",
                "fans_count",
                "follow_count",
            ]);
        });
    }
}
