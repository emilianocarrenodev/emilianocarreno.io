<?php

namespace Tests\Feature;

use App\Mail\AsistenteVirtualMail;
use Tests\TestCase;

class AsistenteVirtualTest extends TestCase
{
    public function test_the_email_mailable_renders_branded_html_and_plain_text_content(): void
    {
        $mail = new AsistenteVirtualMail;

        $mail->assertHasSubject('Emiliano Carreño | Full Stack Developer & Salesforce')
            ->assertSeeInHtml('Hola, soy Emiliano Carreño')
            ->assertSeeInHtml('10+ años · Laravel')
            ->assertSeeInHtml('Ver portafolio')
            ->assertSeeInText('10+ años con Laravel')
            ->assertSeeInText('Este mensaje fue enviado por el asistente virtual de Emiliano Carreño.');
    }

    public function test_the_email_html_uses_email_client_compatible_markup(): void
    {
        $html = (new AsistenteVirtualMail)->render();

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
