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
        Schema::create('email_open_trackings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('sent_email_id')->constrained()->cascadeOnDelete();
            $table->string('channel');
            $table->uuid('tracking_token')->unique();
            $table->timestamp('opened_at')->nullable();
            $table->timestamps();

            $table->index(['sent_email_id', 'opened_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_open_trackings');
    }
};
