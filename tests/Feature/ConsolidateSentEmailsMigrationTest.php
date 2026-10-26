<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ConsolidateSentEmailsMigrationTest extends TestCase
{
    public function test_it_moves_existing_email_records_and_restores_them_on_rollback(): void
    {
        config([
            'database.connections.sent_email_migration_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
        DB::purge('sent_email_migration_test');
        DB::setDefaultConnection('sent_email_migration_test');

        $legacySources = [
            'asistente_virtual_email_sends' => 'asistente_virtual',
            'salesforce_email_sends' => 'salesforce',
            'wordpress_email_sends' => 'wordpress',
        ];
        $sentAt = '2026-01-01 12:00:00';

        foreach (array_keys($legacySources) as $tableName) {
            Schema::create($tableName, function (Blueprint $table): void {
                $table->id();
                $table->string('email')->unique();
                $table->timestamps();
            });

            DB::table($tableName)->insert([
                'email' => 'persona@example.com',
                'created_at' => $sentAt,
                'updated_at' => $sentAt,
            ]);
        }

        $migration = require database_path('migrations/2026_10_26_232648_consolidate_email_sends_into_sent_emails_table.php');
        $migration->up();

        $this->assertDatabaseCount('sent_emails', 3);

        foreach ($legacySources as $tableName => $source) {
            $this->assertDatabaseHas('sent_emails', [
                'email' => 'persona@example.com',
                'source' => $source,
                'created_at' => $sentAt,
            ]);
            $this->assertFalse(Schema::hasTable($tableName));
        }

        $migration->down();

        foreach (array_keys($legacySources) as $tableName) {
            $this->assertDatabaseHas($tableName, [
                'email' => 'persona@example.com',
                'created_at' => $sentAt,
            ]);
        }

        $this->assertFalse(Schema::hasTable('sent_emails'));
    }
}
