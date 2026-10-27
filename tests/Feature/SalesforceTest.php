<?php

namespace Tests\Feature;

use App\Mail\SalesforceMail;
use Tests\TestCase;

class SalesforceTest extends TestCase
{
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
}
