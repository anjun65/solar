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
        Schema::create('solars', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('mac');
            $table->decimal('voltage', total: 8, places: 2);
            $table->decimal('current', total: 8, places: 2);
            $table->decimal('power', total: 8, places: 2);
            $table->decimal('temperature', total: 8, places: 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solars');
    }
};
