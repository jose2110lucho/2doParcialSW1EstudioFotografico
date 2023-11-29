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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('detail');
            $table->string('address');
            $table->string('key_event');
            $table->date('start_date');
            $table->time('start_time');
            $table->smallInteger('privacity');
            $table->foreignId('user_id')->constrained('users')/* ->onDelete('cascade')->onUpdate('cascade') */;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
