<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWechatToOauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_oauth', function (Blueprint $table) {
            $table->string('wechat_open_id')->nullable()->unique();
            $table->string('wechat_mp_id')->nullable()->unique();
            $table->string('wechat_union_id')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_oauth', function (Blueprint $table) {
            $table->dropColumn('wechat_open_id');
            $table->dropColumn('wechat_mp_id');
            $table->dropColumn('wechat_union_id');
        });
    }
}
