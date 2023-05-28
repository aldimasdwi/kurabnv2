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
        Schema::create('kurbans', function (Blueprint $table) {
            $table->id();
            $table->enum('type_kurban', ['sapi_type_A', 'sapi_type_B', 'sapi_type_C', 'kambing_type_A', 'kambing_type_B', 'kambing_type_C']);
            $table->string('harga');
            $table->string('berat');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurbans');
    }
};
