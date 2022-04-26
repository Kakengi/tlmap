<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->tinyInteger('school_class_id')->unsigned();
            $table->tinyInteger('region_id')->unsigned();
            $table->string('region_name');
            $table->tinyInteger('district_id')->unsigned();
            $table->string('district_name');
            $table->mediumInteger('ward_id')->unsigned();
            $table->string('ward_name');
            $table->tinyInteger('subject_id')->unsigned();
            $table->tinyInteger('school_type_id')->unsigned();
            $table->integer('year_of_study');
            $table->integer('num_students');
            $table->integer('required_books');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('school_type_id')->references('id')->on('school_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_requirements');
    }
}
