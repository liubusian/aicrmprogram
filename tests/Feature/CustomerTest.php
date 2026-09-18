<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_index_page_is_accessible_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/customers');

        $response->assertOk();
    }

    public function test_user_can_create_a_customer(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/customers', [
            'name' => 'Alice Chen',
            'company' => 'Acme Co.',
            'email' => 'alice@acme.com',
            'phone' => '0912-345-678',
            'source' => 'website',
            'status' => 'new',
            'notes' => 'Interested in pricing.',
        ]);

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('customers', [
            'name' => 'Alice Chen',
            'email' => 'alice@acme.com',
        ]);
    }

    public function test_customer_list_can_be_filtered_by_search_and_status(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/customers', [
            'name' => 'Alice Chen',
            'company' => 'Acme Co.',
            'email' => 'alice@acme.com',
            'phone' => '0912-345-678',
            'source' => 'website',
            'status' => 'qualified',
            'notes' => 'Interested in pricing.',
        ]);

        $this->actingAs($user)->post('/customers', [
            'name' => 'Bob Wang',
            'company' => 'Beta Labs',
            'email' => 'bob@beta.com',
            'phone' => '0911-222-333',
            'source' => 'referral',
            'status' => 'new',
            'notes' => 'Needs follow-up.',
        ]);

        $response = $this->actingAs($user)->get('/customers?search=alice&status=qualified');

        $response->assertOk();
        $response->assertSee('Alice Chen');
        $response->assertDontSee('Bob Wang');
    }

    public function test_dashboard_shows_live_customer_statistics(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/customers', [
            'name' => 'Alice Chen',
            'company' => 'Acme Co.',
            'email' => 'alice@acme.com',
            'phone' => '0912-345-678',
            'source' => 'website',
            'status' => 'qualified',
            'notes' => 'Interested in pricing.',
        ]);

        $this->actingAs($user)->post('/customers', [
            'name' => 'Bob Wang',
            'company' => 'Beta Labs',
            'email' => 'bob@beta.com',
            'phone' => '0911-222-333',
            'source' => 'referral',
            'status' => 'new',
            'notes' => 'Needs follow-up.',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSeeInOrder(['總客戶數', '2', '本月新增', '1', '待跟進', '1']);
    }

    public function test_customer_index_supports_pagination(): void
    {
        $user = User::factory()->create();

        for ($i = 1; $i <= 11; $i++) {
            Customer::create([
                'name' => 'Customer ' . $i,
                'company' => 'Company ' . $i,
                'email' => 'customer' . $i . '@example.com',
                'phone' => '0912-000-' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'source' => 'website',
                'status' => $i % 2 === 0 ? 'new' : 'qualified',
                'notes' => 'Test note ' . $i,
            ]);
        }

        $response = $this->actingAs($user)->get('/customers');

        $response->assertOk();
        $response->assertSee('page=2');
    }
}
