<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertRedirect(route('home', ['auth' => 'register'], false));
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Zt7!vK2#Lm9@Qa1',
            'password_confirmation' => 'Zt7!vK2#Lm9@Qa1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_new_users_can_register_and_return_to_cart(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'cart-user@example.com',
            'password' => 'Zt7!vK2#Lm9@Qa1',
            'password_confirmation' => 'Zt7!vK2#Lm9@Qa1',
            'redirect_to' => '/cart',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/cart');
    }
}
