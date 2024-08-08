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
        Schema::create('paramsfactures', function (Blueprint $table) {
            $table->id();
            $table->string('ifu');
            $table->string('token');
            $table->string('taxe');
            $table->string('type');
            $table->binary('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paramsfactures');
    }
};
