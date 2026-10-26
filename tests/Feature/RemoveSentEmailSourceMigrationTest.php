<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RemoveSentEmailSourceMigrationTest extends TestCase
{
    public function test_it_removes_the_source_column_and_keeps_one_record_per_email(): void
    {
        config([
            'database.connections.sent_email_source_migration_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
        DB::purge('sent_email_source_migration_test');
        DB::setDefaultConnection('sent_email_source_migration_test');

        Schema::create('sent_emails', function (Blueprint $table): void {
            $table->id();
            $table->string('email');
            $table->string('source', 32);
            $table->timestamps();
            $table->unique(['email', 'source']);
        });

        DB::table('sent_emails')->insert([
            [
                'email' => 'persona@example.com',
                'source' => 'salesforce',
                'created_at' => '2026-01-01 12:00:00',
                'updated_at' => '2026-01-01 12:00:00',
            ],
            [
                'email' => 'persona@example.com',
                'source' => 'wordpress',
                'created_at' => '2026-01-02 12:00:00',
                'updated_at' => '2026-01-02 12:00:00',
            ],
        ]);

        $migration = require database_path('migrations/2026_10_26_232951_remove_source_from_sent_emails_and_enforce_unique_email.php');
        $migration->up();

        $this->assertDatabaseCount('sent_emails', 1);
        $this->assertFalse(Schema::hasColumn('sent_emails', 'source'));
        $this->assertDatabaseHas('sent_emails', [
            'email' => 'persona@example.com',
            'created_at' => '2026-01-01 12:00:00',
        ]);

        $migration->down();

        $this->assertTrue(Schema::hasColumn('sent_emails', 'source'));
        $this->assertDatabaseHas('sent_emails', [
            'email' => 'persona@example.com',
            'source' => 'legacy',
        ]);
    }
}
