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
        Schema::create('person_contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('person_id')->unsigned()->index()->nullable();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
            $table->string('contact_type');
            $table->string('contact_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_contacts');
    }
};
