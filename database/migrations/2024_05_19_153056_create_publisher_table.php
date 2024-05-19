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
        Schema::create("publishers", function (Blueprint $table) {
            $table->bigIncrements('id')->primary()->autoIncrement()->unique();
            $table->string("name", 30)->unique();
            $table->string("email", 255)->unique();
            $table->string("phone", 30)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("publishers");
    }
};
