<?php

namespace Tests\Feature;

use App\Mail\WordPressMail;
use Tests\TestCase;

class WordPressTest extends TestCase
{
    public function test_the_mail_renders_wordpress_branded_html_and_plain_text_content(): void
    {
        $mail = new WordPressMail;

        $mail->assertHasSubject('Emiliano Carreño | Desarrollo WordPress')
            ->assertSeeInHtml('Desarrollo web · WordPress · WooCommerce')
            ->assertSeeInHtml('WordPress y Elementor')
            ->assertSeeInHtml('YourCreams, Segreco, Bufito y Clínica Mireia Espinosa')
            ->assertSeeInHtml('#0172cc')
            ->assertSeeInText('Desarrollo a medida')
            ->assertSeeInText('Este mensaje fue enviado por el canal de WordPress de Emiliano Carreño.');
    }

    public function test_the_email_html_uses_email_client_compatible_markup(): void
    {
        $html = (new WordPressMail)->render();

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
