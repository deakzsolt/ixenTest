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
        Schema::create('person_address', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('person_id')->unsigned()->index()->unique();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
            $table->string('permanent_address');
            $table->string('temporary_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_address');
    }
};
