<?php

namespace Tests\Feature;

use App\Models\SentEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SentEmailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.validate_url.code' => 'shared-test-code',
        ]);
    }

    public function test_an_email_address_cannot_receive_another_email_type(): void
    {
        $sentEmail = SentEmail::create(['email' => 'persona@example.com']);
        $sentEmail->recordOpenTracking('asistente-virtual');
        Mail::fake();

        $response = $this->post(route('envio-emails.send', ['code' => 'shared-test-code']), [
            'email' => 'persona@example.com',
            'email_type' => 'salesforce',
        ]);

        $response->assertRedirect(route('envio-emails', ['code' => 'shared-test-code']))
            ->assertSessionHas('error', 'Ya se envió un email a esta dirección.');

        $this->assertDatabaseCount('sent_emails', 1);
        $this->assertDatabaseCount('email_open_trackings', 1);
        Mail::assertNothingOutgoing();
    }
}
