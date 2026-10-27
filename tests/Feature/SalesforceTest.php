<?php

namespace Tests\Feature;

use App\Mail\SalesforceMail;
use App\Models\SentEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SalesforceTest extends TestCase
{
    use RefreshDatabase;

    private const ACCESS_CODE = 'test-salesforce-access-code';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.validate_url.code' => self::ACCESS_CODE]);
    }

    public function test_the_mail_renders_salesforce_branded_html_and_plain_text_content(): void
    {
        $mail = new SalesforceMail;

        $mail->assertHasSubject('Emiliano Carreño | Full Stack Developer & Salesforce')
            ->assertSeeInHtml('Salesforce CRM · Integraciones · Cloud')
            ->assertSeeInHtml('Implementación e integración de soluciones')
            ->assertSeeInHtml('10+ años · Desarrollo web')
            ->assertSeeInText('8+ años en frontend e integraciones')
            ->assertSeeInText('Este mensaje fue enviado por el canal de Salesforce de Emiliano Carreño.');
    }

    public function test_the_email_html_uses_email_client_compatible_markup(): void
    {
        $html = (new SalesforceMail)->render();

        $this->assertStringContainsString(
            '<div style="margin: 0; background-color: #f3f3f3;',
            $html,
        );
        $this->assertStringContainsString('<html lang="es">', $html);
        $this->assertStringNotContainsString('<body', $html);
        $this->assertStringNotContainsString('target=', $html);
        $this->assertStringNotContainsString('display: inline-block', $html);
        $this->assertStringNotContainsString('opacity:', $html);
        $this->assertStringNotContainsString('border-radius:', $html);
        $this->assertStringNotContainsString('overflow:', $html);
    }

    public function test_it_sends_and_records_an_email_address(): void
    {
        Mail::fake();

        $response = $this->getJson(route('salesforce', [
            'email' => 'persona@example.com',
            'code' => self::ACCESS_CODE,
        ]));

        $response->assertCreated()
            ->assertJson(['message' => 'Email enviado correctamente.']);

        $this->assertDatabaseHas('sent_emails', [
            'email' => 'persona@example.com',
        ]);

        Mail::assertSent(SalesforceMail::class, function (SalesforceMail $mail): bool {
            return $mail->hasTo('persona@example.com');
        });
    }

    public function test_it_returns_409_and_does_not_resend_to_a_recorded_address(): void
    {
        Mail::fake();

        SentEmail::create([
            'email' => 'persona@example.com',
            'source' => 'salesforce',
        ]);

        $response = $this->getJson(route('salesforce', [
            'email' => 'PERSONA@example.com',
            'code' => self::ACCESS_CODE,
        ]));

        $response->assertStatus(409)
            ->assertJson(['message' => 'Ya se envió un email a esta dirección.']);

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 1);
    }

    public function test_it_requires_a_valid_email_address(): void
    {
        Mail::fake();

        $response = $this->getJson(route('salesforce', [
            'email' => 'no-es-un-email',
            'code' => self::ACCESS_CODE,
        ]));

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('email');

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 0);
    }

    public function test_it_returns_a_blank_page_and_does_not_send_with_an_invalid_code(): void
    {
        Mail::fake();

        $response = $this->get(route('salesforce', [
            'email' => 'persona@example.com',
            'code' => 'incorrect-code',
        ]));

        $response->assertOk()
            ->assertContent('');

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 0);
    }
}
