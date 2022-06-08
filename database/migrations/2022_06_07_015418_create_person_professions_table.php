<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_professions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('person_id')
                ->constrained('people', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('profession_id')
                ->constrained('professions', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_professions');
    }
};
