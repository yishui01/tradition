<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->integer("user_id")->default(0);
            $table->integer("category_id")->default(0);
            $table->integer("reply_count")->default(0);
            $table->integer("view_count")->default(0);
            $table->integer("nice_count")->default(0);
            $table->integer("last_reply_user_id")->default(0);
            $table->integer("order")->default(0);
            $table->text("excerpt");
            $table->string("slug")->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn("user_id");
            $table->dropColumn("category_id");
            $table->dropColumn("reply_count");
            $table->dropColumn("view_count");
            $table->dropColumn("nice_count");
            $table->dropColumn("last_reply_user_id");
            $table->dropColumn("order");
            $table->dropColumn("excerpt");
            $table->dropColumn("slug");
        });
    }
}
