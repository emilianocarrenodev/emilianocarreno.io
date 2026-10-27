<?php

namespace Tests\Feature;

use App\Mail\AsistenteVirtualMail;
use App\Mail\SalesforceMail;
use App\Mail\WordPressMail;
use App\Models\SentEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EnvioEmailsTest extends TestCase
{
    use RefreshDatabase;

    private const ACCESS_CODE = 'test-email-send-access-code';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.validate_url.code' => self::ACCESS_CODE]);
    }

    public function test_it_displays_a_form_with_all_email_types(): void
    {
        $response = $this->get(route('envio-emails', ['code' => self::ACCESS_CODE]));

        $response->assertOk()
            ->assertSee('Envío de')
            ->assertSee(route('envio-emails.send', ['code' => self::ACCESS_CODE]), false)
            ->assertSee('name="email_type"', false)
            ->assertSee('value="asistente-virtual"', false)
            ->assertSee('value="salesforce"', false)
            ->assertSee('value="wordpress"', false);
    }

    public function test_it_sends_the_assistant_email_selected_in_the_form(): void
    {
        $this->assertSelectedEmailIsSent(
            'asistente-virtual',
            'Asistente virtual',
            AsistenteVirtualMail::class,
        );
    }

    public function test_it_sends_the_salesforce_email_selected_in_the_form(): void
    {
        $this->assertSelectedEmailIsSent('salesforce', 'Salesforce', SalesforceMail::class);
    }

    public function test_it_sends_the_wordpress_email_selected_in_the_form(): void
    {
        $this->assertSelectedEmailIsSent('wordpress', 'WordPress', WordPressMail::class);
    }

    public function test_it_does_not_send_any_email_type_again_to_one_address(): void
    {
        $sentEmail = SentEmail::create(['email' => 'persona@example.com']);
        $sentEmail->recordOpenTracking('asistente-virtual');
        Mail::fake();

        $response = $this->post(route('envio-emails.send', ['code' => self::ACCESS_CODE]), [
            'email' => 'PERSONA@example.com',
            'email_type' => 'wordpress',
        ]);

        $response->assertRedirect(route('envio-emails', ['code' => self::ACCESS_CODE]))
            ->assertSessionHas('error', 'Ya se envió un email a esta dirección.');

        $this->assertDatabaseCount('email_open_trackings', 1);
        Mail::assertNothingOutgoing();
    }

    public function test_it_requires_a_valid_email_address(): void
    {
        Mail::fake();

        $response = $this->from(route('envio-emails', ['code' => self::ACCESS_CODE]))
            ->post(route('envio-emails.send', ['code' => self::ACCESS_CODE]), [
                'email' => 'no-es-un-email',
                'email_type' => 'salesforce',
            ]);

        $response->assertRedirect(route('envio-emails', ['code' => self::ACCESS_CODE]))
            ->assertSessionHasErrors([
                'email' => 'Introduce un correo electrónico válido.',
            ]);

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 0);
    }

    public function test_it_rejects_an_email_type_that_is_not_available_in_the_form(): void
    {
        Mail::fake();

        $response = $this->from(route('envio-emails', ['code' => self::ACCESS_CODE]))
            ->post(route('envio-emails.send', ['code' => self::ACCESS_CODE]), [
                'email' => 'persona@example.com',
                'email_type' => 'not-available',
            ]);

        $response->assertRedirect(route('envio-emails', ['code' => self::ACCESS_CODE]))
            ->assertSessionHasErrors([
                'email_type' => 'Selecciona un tipo de email válido.',
            ]);

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 0);
    }

    public function test_it_does_not_send_with_an_invalid_access_code(): void
    {
        Mail::fake();

        $response = $this->post(route('envio-emails.send', ['code' => 'incorrect-code']), [
            'email' => 'persona@example.com',
            'email_type' => 'salesforce',
        ]);

        $response->assertOk()
            ->assertContent('');

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 0);
    }

    public function test_the_previous_salesforce_url_no_longer_sends_emails(): void
    {
        Mail::fake();

        $this->get('/salesforce/'.self::ACCESS_CODE.'/persona@example.com')
            ->assertNotFound();

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 0);
    }

    public function test_the_previous_assistant_url_no_longer_sends_emails(): void
    {
        Mail::fake();

        $this->get('/asistente-virtual/'.self::ACCESS_CODE.'/persona@example.com')
            ->assertNotFound();

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 0);
    }

    public function test_the_previous_wordpress_url_no_longer_sends_emails(): void
    {
        Mail::fake();

        $this->get('/wordpress/'.self::ACCESS_CODE.'/persona@example.com')
            ->assertNotFound();

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('sent_emails', 0);
    }

    private function assertSelectedEmailIsSent(string $emailType, string $typeLabel, string $mailClass): void
    {
        Mail::fake();

        $response = $this->post(route('envio-emails.send', ['code' => self::ACCESS_CODE]), [
            'email' => 'persona@example.com',
            'email_type' => $emailType,
        ]);

        $response->assertRedirect(route('envio-emails', ['code' => self::ACCESS_CODE]))
            ->assertSessionHas('status', 'El email de tipo '.$typeLabel.' se envió correctamente.');

        $this->assertDatabaseHas('sent_emails', [
            'email' => 'persona@example.com',
        ]);
        $this->assertDatabaseHas('email_open_trackings', [
            'channel' => $emailType,
        ]);
        Mail::assertSent($mailClass, function (Mailable $mail): bool {
            return $mail->hasTo('persona@example.com');
        });
    }
}
