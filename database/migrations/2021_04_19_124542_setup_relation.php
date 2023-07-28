<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetupRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conf_users', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('conf_group');
        });

        Schema::table('conf_menu', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('conf_menu');
        });

        Schema::table('conf_group_menu', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('conf_group');
            $table->foreign('menu_id')->references('id')->on('conf_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
