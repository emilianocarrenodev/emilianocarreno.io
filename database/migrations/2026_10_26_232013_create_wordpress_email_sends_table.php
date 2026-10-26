<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('wordpress_email_sends')) {
            Schema::create('wordpress_email_sends', function (Blueprint $table): void {
                $table->id();
                $table->string('email')->unique();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('wordpress_email_sends');
    }
};
