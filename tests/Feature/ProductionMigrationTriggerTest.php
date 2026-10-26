<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductionMigrationTriggerTest extends TestCase
{
    private const CODE = 'test-assistant-access-code';

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['env'] = 'production';
        config(['services.asistente_virtual.code' => self::CODE]);
    }

    public function test_it_requires_production_and_the_configured_code(): void
    {
        $response = $this->get('/maintenance/migrations/incorrect-code');

        $response->assertOk()->assertContent('');

        $this->app['env'] = 'testing';

        $this->get('/maintenance/migrations/'.self::CODE)->assertNotFound();
    }

    public function test_it_does_not_run_migrations_when_the_configured_code_is_missing(): void
    {
        Artisan::shouldReceive('call')->never();
        config(['services.asistente_virtual.code' => '']);

        $response = $this->post('/maintenance/migrations/'.self::CODE);

        $response->assertOk()->assertContent('');
    }

    public function test_get_only_displays_the_confirmation_page(): void
    {
        Artisan::shouldReceive('call')->never();

        $response = $this->get('/maintenance/migrations/'.self::CODE);

        $response->assertOk()
            ->assertSee('Esta acción ejecutará todas las migraciones pendientes')
            ->assertSee('Ejecutar migraciones pendientes');
    }

    public function test_post_runs_pending_migrations_with_production_flags(): void
    {
        Artisan::shouldReceive('call')
            ->once()
            ->with('migrate', ['--force' => true, '--no-interaction' => true])
            ->andReturn(0);

        Artisan::shouldReceive('output')
            ->once()
            ->andReturn('Nothing to migrate.');

        $response = $this->post('/maintenance/migrations/'.self::CODE);

        $response->assertOk()
            ->assertSee('El comando de migraciones terminó correctamente.')
            ->assertSee('Nothing to migrate.');
    }

    public function test_it_reports_a_failed_migration_command(): void
    {
        Artisan::shouldReceive('call')
            ->once()
            ->andReturn(1);

        Artisan::shouldReceive('output')
            ->once()
            ->andReturn('Migration failed.');

        $response = $this->post('/maintenance/migrations/'.self::CODE);

        $response->assertServerError()
            ->assertSee('El comando de migraciones terminó con errores.')
            ->assertSee('Migration failed.');
    }
}
