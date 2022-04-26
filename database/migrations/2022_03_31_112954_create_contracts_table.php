<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_title', 255);
            $table->UnsignedBigInteger('supplier_id');
            $table->string('contract_number')->nullable();
            $table->integer('contract_year')->nullable();
            $table->integer('year_of_study');
            $table->string('delivery_date')->nullable();
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->enum('contract_status', ['active', 'closed'])
                ->nullable()
                ->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
