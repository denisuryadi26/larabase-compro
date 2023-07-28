<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create( 'tbl_about', function (Blueprint $table) {
                $table->uuid('id');
                $table->primary('id');

                $table->string("judul");
                $table->string("subjudul");
                $table->string("deskripsi_1");
                $table->string("deskripsi_2");
                $table->string("kelebihan_1");
                $table->string("kelebihan_2");
                $table->string("kelebihan_3");
                $table->string("kelebihan_4");
                

                $table->softDeletes();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
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