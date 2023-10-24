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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('picture_url');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('species')->index();
            $table->enum('gender', ['Masculin', 'Féminin', 'Non genré', 'Inconnu'])->index();
            $table->enum('status', ['En vie', 'Décédé', 'Inconnu']);
            $table->string('origin');
            $table->json('episodes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
