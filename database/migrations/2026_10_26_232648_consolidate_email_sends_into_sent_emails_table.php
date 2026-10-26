<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var array<string, string>
     */
    private array $legacyTables = [
        'asistente_virtual_email_sends' => 'asistente_virtual',
        'salesforce_email_sends' => 'salesforce',
        'wordpress_email_sends' => 'wordpress',
    ];

    public function up(): void
    {
        Schema::create('sent_emails', function (Blueprint $table): void {
            $table->id();
            $table->string('email');
            $table->string('source', 32);
            $table->timestamps();
            $table->unique(['email', 'source']);
        });

        foreach ($this->legacyTables as $tableName => $source) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            $rows = DB::table($tableName)
                ->select(['email', 'created_at', 'updated_at'])
                ->orderBy('id')
                ->get()
                ->map(fn (object $row): array => [
                    'email' => $row->email,
                    'source' => $source,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ])
                ->all();

            if ($rows !== []) {
                DB::table('sent_emails')->insertOrIgnore($rows);
            }

            Schema::drop($tableName);
        }
    }

    public function down(): void
    {
        foreach ($this->legacyTables as $tableName => $source) {
            Schema::create($tableName, function (Blueprint $table): void {
                $table->id();
                $table->string('email')->unique();
                $table->timestamps();
            });

            $rows = DB::table('sent_emails')
                ->where('source', $source)
                ->select(['email', 'created_at', 'updated_at'])
                ->get()
                ->map(fn (object $row): array => [
                    'email' => $row->email,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ])
                ->all();

            if ($rows !== []) {
                DB::table($tableName)->insertOrIgnore($rows);
            }
        }

        Schema::drop('sent_emails');
    }
};
