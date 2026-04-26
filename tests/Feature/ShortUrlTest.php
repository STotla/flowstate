<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;
    public $superAdmin;
    public $admin;
    public $company;

    public $member;

    public $secondCompany;
    public $secondCompanyAdmin;

    public $secondCompanyMember;
    
    public function setup(): void
    {
        parent::setUp();
        $this->seed();
        $this->superAdmin = User::first();

        $this->company = Company::create([
            'name' => 'Test Company',
            'address' => '123 Test Street',
        ]);
        $this->secondCompany = Company::create([
            'name' => 'Second Company',
            'address' => '456 Second Street',
        ]);
        $this->admin = User::factory()->create([
            'company_id' => $this->company->id,
        ]);
        $this->admin->assignRole('Admin');
        $this->member = User::factory()->create([
            'company_id' => $this->company->id,
        ]);
        $this->member->assignRole('Member');

    }

    public function test_short_url_creation_by_Admin()
    {
        $company = $this->company;
        $user = $this->admin;

        $response = $this->actingAs($user)->post('/shorturls', [
            'original_url' => 'https://www.example.com',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('shorturl', [
            'company_id' => $company->id,
            'user_id' => $user->id,
            'original_url' => 'https://www.example.com',
        ]);
    }

    public function test_short_url_creation_by_Member()
    {
        $company = $this->company;
        $user = $this->member;

        $response = $this->actingAs($user)->post('/shorturls', [
            'original_url' => 'https://www.example.com',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('shorturl', [
            'company_id' => $company->id,
            'user_id' => $user->id,
            'original_url' => 'https://www.example.com',
        ]);
    }
    public function test_short_url_cannot_be_created_by_SuperAdmin()
    {
        $company = $this->company;
        $user = $this->superAdmin;

        $response = $this->actingAs($user)->post('/shorturls', [
            'original_url' => 'https://www.example/new.com',
        ]);

       $response->assertStatus(403); 

    $this->assertDatabaseMissing('shorturl', [
        'original_url' => 'https://www.example/new.com',
    ]);

}

public function test_short_url_creation_with_invalid_url()
{
    $company = $this->company;
    $user = $this->admin;

    $response = $this->actingAs($user)->post('/shorturls', [
        'original_url' => 'invalid-url',
    ]);

    $response->assertSessionHasErrors('original_url');
    $this->assertDatabaseMissing('shorturl', [
        'original_url' => 'invalid-url',
    ]);         
}

}