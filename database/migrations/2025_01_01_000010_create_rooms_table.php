<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ditambahkan belakangan (semula ditunda) karena validasi bentrok ruang di
        // Fase 4 butuh perbandingan ID yang akurat, bukan teks bebas yang rawan typo.
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // contoh: R201
            $table->string('name', 100);           // contoh: Ruang 201 Lantai 2
            $table->unsignedInteger('capacity')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
