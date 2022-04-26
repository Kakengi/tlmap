<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('publication_title', 190);
            $table->bigInteger('book_id')->unsigned();
            $table->bigInteger('author_id')->unsigned()->nullable();
            $table->integer('number_of_pages')->nullable();
            $table->integer('publication_year')->nullable();
            $table->boolean('is_large_print')->default(false);
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->string('filename')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('restrict')->onUpdate('cascade');
            $table->unique(['book_id', 'publication_year', 'is_large_print']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
