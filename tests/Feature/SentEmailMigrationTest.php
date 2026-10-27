<?php

namespace Tests\Feature;

use App\Models\SentEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SentEmailMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_keeps_existing_sent_emails_when_the_create_migration_runs_again(): void
    {
        $sentEmail = SentEmail::create(['email' => 'persona@example.com']);
        $migration = require database_path('migrations/2026_10_26_234909_create_sent_emails_table.php');

        $migration->up();

        $this->assertDatabaseHas('sent_emails', [
            'id' => $sentEmail->id,
            'email' => 'persona@example.com',
        ]);
    }
}
