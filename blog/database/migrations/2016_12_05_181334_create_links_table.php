<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'MyIsam';
            $table->increments('link_id');
            $table->string('link_name')->defulte('')->comment('//友情链接名称');
            $table->string('link_title')->defulte('')->comment('//友情链接标题');;
            $table->string('link_url')->defulte('')->comment('//友情链接地址');;
            $table->integer('link_order')->defulte(0)->comment('//友情链接排序');;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
