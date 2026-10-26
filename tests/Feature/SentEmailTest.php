<?php

namespace Tests\Feature;

use App\Mail\AsistenteVirtualMail;
use App\Mail\SalesforceMail;
use App\Mail\WordPressMail;
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
            'services.asistente_virtual.code' => 'assistant-test-code',
            'services.salesforce.code' => 'salesforce-test-code',
            'services.wordpress.code' => 'wordpress-test-code',
        ]);
    }

    public function test_the_same_email_cannot_receive_another_channel_email(): void
    {
        Mail::fake();

        $this->getJson(route('asistente-virtual', [
            'email' => 'persona@example.com',
            'code' => 'assistant-test-code',
        ]))->assertCreated();

        $this->getJson(route('salesforce', [
            'email' => 'persona@example.com',
            'code' => 'salesforce-test-code',
        ]))->assertStatus(409)
            ->assertJson(['message' => 'Ya se envió un email a esta dirección.']);

        $this->getJson(route('wordpress', [
            'email' => 'persona@example.com',
            'code' => 'wordpress-test-code',
        ]))->assertStatus(409)
            ->assertJson(['message' => 'Ya se envió un email a esta dirección.']);

        $this->assertDatabaseCount('sent_emails', 1);
        $this->assertDatabaseHas('sent_emails', [
            'email' => 'persona@example.com',
        ]);

        Mail::assertSent(AsistenteVirtualMail::class);
        Mail::assertNotSent(SalesforceMail::class);
        Mail::assertNotSent(WordPressMail::class);
    }
}
