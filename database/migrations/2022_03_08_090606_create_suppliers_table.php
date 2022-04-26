<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //$table->unsignedBigInteger('country_id');
            $table->UnsignedTinyInteger('region_id');
            $table->UnsignedTinyInteger('district_id');
            $table->string('address');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->unsignedBigInteger('created_by');
            $table->softDeletes();
            //$table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('suppliers');
    }
}
