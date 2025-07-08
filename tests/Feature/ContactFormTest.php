<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ContactForm;
use App\Models\User;

class ContactFormTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_contact_form_can_be_stored()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            'name' => '田中太郎',
            'title' => 'ご質問',
            'email' => 'tanaka@example.com',
            'url' => 'https://example.com',
            'gender' => 1,
            'age' => 30,
            'contact' => 'テストメッセージ',
            'caution' => 1,
        ];
        $response = $this->post('/contacts', $data);
        $response->assertRedirect('/contacts');
        $this->assertDatabaseHas('contact_forms', [
            'name' => '田中太郎',
            'email' => 'tanaka@example.com',
        ]);
    }
}
