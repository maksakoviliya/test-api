<?php

declare(strict_types=1);

use App\Models\Slot;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holds', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Slot::class)->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->uuid('idempotency_key')->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holds');
    }
};
