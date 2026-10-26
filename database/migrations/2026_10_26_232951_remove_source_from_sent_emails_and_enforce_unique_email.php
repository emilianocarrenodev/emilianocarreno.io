<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('sent_emails')
            ->whereNotIn('id', DB::table('sent_emails')->selectRaw('MIN(id)')->groupBy('email'))
            ->delete();

        Schema::table('sent_emails', function (Blueprint $table): void {
            $table->dropUnique('sent_emails_email_source_unique');
            $table->dropColumn('source');
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sent_emails', function (Blueprint $table): void {
            $table->dropUnique('sent_emails_email_unique');
            $table->string('source', 32)->default('legacy');
            $table->unique(['email', 'source']);
        });
    }
};
