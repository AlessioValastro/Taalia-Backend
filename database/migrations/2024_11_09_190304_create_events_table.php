<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Esegui la migrazione.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('organizer');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Annulla la migrazione.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
