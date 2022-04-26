<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication_contract', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('publication_id')->unsigned();
            $table->bigInteger('contract_id')->unsigned();
            $table->integer('quantity');
            $table->boolean('is_for_sale')->default(false);
            $table->timestamps();
            $table->foreign('publication_id')->references('id')->on('publications')->onDelete('restrict');
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict');
            $table->unique(['contract_id', 'publication_id', 'is_for_sale'], 'publication_contract_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publication_contracts');
    }
}
