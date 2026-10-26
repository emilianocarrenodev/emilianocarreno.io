<?php

namespace Tests\Feature;

use App\Mail\AsistenteVirtualMail;
use App\Models\AsistenteVirtualEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AsistenteVirtualTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sends_and_records_an_email_address(): void
    {
        Mail::fake();

        $response = $this->postJson(route('asistente-virtual'), [
            'email' => 'persona@example.com',
        ]);

        $response->assertCreated()
            ->assertJson(['message' => 'Email enviado correctamente.']);

        $this->assertDatabaseHas('asistente_virtual_email_sends', [
            'email' => 'persona@example.com',
        ]);

        Mail::assertSent(AsistenteVirtualMail::class, function (AsistenteVirtualMail $mail): bool {
            return $mail->hasTo('persona@example.com');
        });
    }

    public function test_it_does_not_send_another_email_to_a_recorded_address(): void
    {
        Mail::fake();

        AsistenteVirtualEmail::create(['email' => 'persona@example.com']);

        $response = $this->postJson(route('asistente-virtual'), [
            'email' => 'PERSONA@example.com',
        ]);

        $response->assertStatus(409)
            ->assertJson(['message' => 'Ya se envió un email a esta dirección.']);

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('asistente_virtual_email_sends', 1);
    }

    public function test_it_requires_a_valid_email_address(): void
    {
        Mail::fake();

        $response = $this->postJson(route('asistente-virtual'), [
            'email' => 'no-es-un-email',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('email');

        Mail::assertNothingOutgoing();
        $this->assertDatabaseCount('asistente_virtual_email_sends', 0);
    }
}
