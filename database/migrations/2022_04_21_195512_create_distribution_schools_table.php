<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_schools', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('publication_id')->unsigned();
            $table->bigInteger('school_id')->unsigned();
            $table->integer('year_of_study');
            $table->integer('number_of_boxes');
            $table->integer('loose')->default(0);
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('received_by')->unsigned()->nullable();
            $table->enum('status', ['Pending', 'Received']);
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('received_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('publication_id')->references('id')->on('publications')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribution_schools');
    }
}
