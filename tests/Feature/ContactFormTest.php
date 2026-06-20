<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_submission_is_stored_and_redirects(): void
    {
        Mail::fake();

        $response = $this->post('/kontakt', [
            'name'    => 'Тест Корисник',
            'email'   => 'test@example.com',
            'message' => 'Тестна порака за проверка.',
            'website' => '',
        ]);

        $response->assertRedirect('/kontakt');
        $response->assertSessionHas('success', true);

        $this->assertDatabaseHas('contact_messages', [
            'email'   => 'test@example.com',
            'name'    => 'Тест Корисник',
            'status'  => 'new',
        ]);
    }

    public function test_honeypot_filled_redirects_silently_without_storing(): void
    {
        Mail::fake();

        $response = $this->post('/kontakt', [
            'name'    => 'Bot',
            'email'   => 'bot@spam.com',
            'message' => 'Спам порака',
            'website' => 'http://spam.com',
        ]);

        $response->assertRedirect('/kontakt');
        $response->assertSessionHas('success', true);

        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'bot@spam.com',
        ]);
    }

    public function test_required_fields_return_validation_errors(): void
    {
        $response = $this->post('/kontakt', [
            'name'    => '',
            'email'   => '',
            'message' => '',
            'website' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_invalid_email_returns_validation_error(): void
    {
        $response = $this->post('/kontakt', [
            'name'    => 'Тест',
            'email'   => 'не-е-валиден-емаил',
            'message' => 'Порака',
            'website' => '',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_optional_fields_are_stored_correctly(): void
    {
        Mail::fake();

        $this->post('/kontakt', [
            'name'             => 'Марко Марковски',
            'email'            => 'marko@test.com',
            'phone'            => '+389 77 123 456',
            'service_interest' => 'Даночен консалтинг',
            'message'          => 'Ми треба помош со ДДВ.',
            'website'          => '',
        ]);

        $this->assertDatabaseHas('contact_messages', [
            'email'            => 'marko@test.com',
            'phone'            => '+389 77 123 456',
            'service_interest' => 'Даночен консалтинг',
        ]);
    }
}
