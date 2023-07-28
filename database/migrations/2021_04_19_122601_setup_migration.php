<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetupMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'conf_group', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('code')->nullable(false);
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });

        Schema::create( 'conf_setting', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('parameter');
            $table->string('type');
            $table->string('value');
            $table->softDeletes();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });

        Schema::create( 'conf_menu', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('parent_id')->nullable(true);
            $table->string('code')->nullable(false);
            $table->string('name');
            $table->integer('menu_order');
            $table->string('icon');
            $table->string('route_name')->nullable(true);
            $table->boolean('is_showed')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });

        Schema::create('conf_users', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('group_id');
            $table->string('fullname');
            $table->string('username');
//            $table->string('email')->unique()->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('password');
            $table->string('profile_picture')->nullable(true);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });

        Schema::create('conf_group_menu', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('group_id');
            $table->uuid('menu_id');
            $table->boolean('is_addable')->nullable()->default(false);
            $table->boolean('is_editable')->nullable()->default(false);
            $table->boolean('is_viewable')->nullable()->default(false);
            $table->boolean('is_deletable')->nullable()->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('conf_group');
//        Schema::dropIfExists('conf_setting');
//        Schema::dropIfExists('conf_menu');
//        Schema::dropIfExists('conf_users');
//        Schema::dropIfExists('conf_permission');
    }
}
