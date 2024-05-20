<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id')->primary()->autoIncrement()->unique();
            $table->string('ISBN', 13)->unique();
            $table->string('title', 300);
            $table->string('year_of_publication', 5);
            $table->string('edition', 45);
            $table->text('description');
            $table->enum('type', ['Hardcover', 'Paperback', 'Ebook']);
            $table->string('cover_addr', 100);
            $table->integer('number_of_copies');
            $table->bigInteger('publisher_id')->unsigned();
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
