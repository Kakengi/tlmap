<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publication_contract_id');
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('publication_id');
            $table->integer('number_of_boxes');
            $table->integer('quantity_per_box');
            $table->integer('loose')->nullable()->default(0);
            $table->string('gross_weight');
            $table->string('assessment_status')->nullable();
            $table->longText('comments')->nullable();
            $table->tinyInteger('batch_id')->unsigned();
            $table->unsignedBigInteger('received_by');
            $table->enum('status', ['pending', 'received'])->nullable()->default('received');
            $table->foreign('publication_contract_id')->references('id')->on('publication_contract')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('publication_id')->references('id')->on('publications')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('received_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
