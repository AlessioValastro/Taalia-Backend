<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome dell'organizzatore
            $table->string('address'); // Indirizzo dell'organizzatore
            $table->string('email')->unique(); // Email unica
            $table->string('password'); // Password dell'organizzatore
            $table->string('profile_picture')->nullable(); // Immagine del profilo (opzionale)
            $table->timestamps(); // Timestamps per created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizers'); // Elimina la tabella organizer
    }
}
