<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Models\ContactInquiry;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class ContactComplianceTest extends TestCase
{
    use RefreshDatabase;

    public function test_livewire_contact_form_rejects_missing_privacy_consent(): void
    {
        Livewire::test(ContactForm::class)
            ->set('first_name', 'Ada')
            ->set('last_name', 'Lovelace')
            ->set('email', 'ada@example.test')
            ->call('submit')
            ->assertHasErrors(['privacy_consent' => 'accepted']);

        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    public function test_http_contact_form_rejects_missing_privacy_consent(): void
    {
        $this->from('/contact')
            ->post('/contact', [
                'first_name' => 'Ada',
                'last_name' => 'Lovelace',
                'email' => 'ada@example.test',
            ])
            ->assertSessionHasErrors('privacy_consent');

        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    public function test_livewire_contact_form_persists_submission_when_privacy_consent_is_accepted(): void
    {
        Livewire::test(ContactForm::class)
            ->set('inquiry_type', 'buy')
            ->set('first_name', 'Ada')
            ->set('last_name', 'Lovelace')
            ->set('email', 'ada@example.test')
            ->set('phone', '+34 600 000 000')
            ->set('message', 'Please send available properties.')
            ->set('privacy_consent', true)
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('contact_inquiries', [
            'inquiry_type' => 'buy',
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.test',
            'phone' => '+34 600 000 000',
            'message' => 'Please send available properties.',
        ]);

        $inquiry = ContactInquiry::query()->sole();

        $this->assertFalse(Schema::hasColumn('contact_inquiries', 'privacy_consent'));
        $this->assertArrayNotHasKey('privacy_consent', $inquiry->getAttributes());
    }

    public function test_http_contact_form_persists_submission_when_privacy_consent_is_accepted(): void
    {
        $this->from('/contact')
            ->post('/contact', [
                'inquiry_type' => 'buy',
                'first_name' => 'Ada',
                'last_name' => 'Lovelace',
                'email' => 'ada@example.test',
                'phone' => '+34 600 000 000',
                'message' => 'Please send available properties.',
                'privacy_consent' => 'on',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contact_inquiries', [
            'inquiry_type' => 'buy',
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.test',
            'phone' => '+34 600 000 000',
            'message' => 'Please send available properties.',
        ]);

        $inquiry = ContactInquiry::query()->sole();

        $this->assertFalse(Schema::hasColumn('contact_inquiries', 'privacy_consent'));
        $this->assertArrayNotHasKey('privacy_consent', $inquiry->getAttributes());
    }

    public function test_public_contact_forms_render_privacy_policy_consent_links(): void
    {
        $this->seed(DatabaseSeeder::class);

        $privacyPolicyUrl = url('/privacy-policy');

        $this->get('/')
            ->assertOk()
            ->assertSee('wire:model="privacy_consent"', false)
            ->assertSeeInOrder([
                'I have read and accept the',
                'href="'.$privacyPolicyUrl.'"',
                'Privacy Policy',
            ], false);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('name="privacy_consent"', false)
            ->assertSeeInOrder([
                'I have read and accept the',
                'href="'.$privacyPolicyUrl.'"',
                'Privacy Policy',
            ], false);
    }
}
