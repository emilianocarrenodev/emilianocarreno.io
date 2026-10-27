<?php

namespace Tests\Feature;

use App\Models\SentEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MaintenanceEmailListTest extends TestCase
{
    use RefreshDatabase;

    private const CODE = 'test-maintenance-email-list-code';

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['env'] = 'production';
        config(['services.validate_url.code' => self::CODE]);
    }

    public function test_it_displays_only_email_and_open_tracking_fields(): void
    {
        $sentEmail = SentEmail::create([
            'email' => 'persona@example.com',
        ]);
        $tracking = $sentEmail->recordOpenTracking('salesforce');
        SentEmail::create(['email' => 'legacy@example.com']);

        DB::table('sent_emails')->where('id', $sentEmail->id)->update([
            'created_at' => '2026-10-25 10:00:00',
            'updated_at' => '2026-10-25 11:00:00',
        ]);
        DB::table('email_open_trackings')->where('id', $tracking->id)->update([
            'opened_at' => '2026-10-25 12:00:00',
        ]);

        $response = $this->get(route('maintenance.emails.index', ['code' => self::CODE]));

        $response->assertOk()
            ->assertSee('persona@example.com')
            ->assertSee('legacy@example.com')
            ->assertSee('2026-10-25 10:00:00')
            ->assertSee('2026-10-25 11:00:00')
            ->assertSee('salesforce')
            ->assertSee('2026-10-25 12:00:00')
            ->assertDontSee($tracking->tracking_token)
            ->assertSee('<th scope="col">ID</th>', false)
            ->assertSee('<th scope="col">Email</th>', false)
            ->assertSee('<th scope="col">Creado</th>', false)
            ->assertSee('<th scope="col">Actualizado</th>', false)
            ->assertSee('<th scope="col">Canal</th>', false)
            ->assertSee('<th scope="col">Abierto</th>', false);
    }

    public function test_it_does_not_display_emails_for_an_invalid_code(): void
    {
        SentEmail::create(['email' => 'persona@example.com']);

        $this->get(route('maintenance.emails.index', ['code' => 'invalid-code']))
            ->assertOk()
            ->assertContent('');
    }

    public function test_it_is_not_available_outside_production(): void
    {
        $this->app['env'] = 'testing';

        $this->get(route('maintenance.emails.index', ['code' => self::CODE]))
            ->assertNotFound();
    }
}
