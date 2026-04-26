<?php
namespace Tests\Feature\Auth;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public $superAdmin;
    public $company;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
         $this->superAdmin = User::first();

        $this->company = Company::create([
            'name' => 'Test Company',
            'address' => '123 Test Street',
        ]);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $url = URL::signedRoute('register', [
            'email' => 'test@example.com',
            'role' => 'Admin',
            'company_id' => $this->company->id,
        ]);
        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertSee('test@example.com'); 
    }

    public function test_new_users_can_register(): void
    {
        $url = URL::signedRoute('register', [
            'email' => 'test@example.com',
            'role' => 'Admin',
            'company_id' => $this->company->id,
        ]);

        $response = $this->post($url, [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'Admin',
            'company_id' => $this->company->id,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
