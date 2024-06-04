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
        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id')->primary()->autoIncrement()->unique();
            $table->string("fullname", 255)->unique();
            $table->string("alias", 255)->unique();
            $table->string("bio", 500)->nullable();
            $table->string('photo_addr', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
