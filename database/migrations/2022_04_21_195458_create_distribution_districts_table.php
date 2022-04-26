<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_districts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('publication_id')->unsigned();
            $table->bigInteger('contract_id')->unsigned();
            $table->tinyInteger('district_id')->unsigned();
            $table->integer('year_of_study');
            $table->integer('quantity_required');
            $table->integer('quantity_per_box');
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
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distribution_districts');
    }
}
