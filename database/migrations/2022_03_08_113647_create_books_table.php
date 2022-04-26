<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 190);
            $table->text('description')->nullable();
            $table->UnsignedTinyInteger('book_category_id');
            $table->UnsignedTinyInteger('school_class_id');
            $table->UnsignedTinyInteger('subject_id');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('book_category_id')->references('id')->on('book_categories')->onDelete('restrict')->onDelete('cascade');
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('restrict')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('restrict')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unique(['book_category_id', 'school_class_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
