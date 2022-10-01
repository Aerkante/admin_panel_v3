<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginReturnAccessTokenTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_return_access_token()
    {
        $email = 'test@adminpanel.com.br';
        $password = 'secret';

        $response = $this->post('/auth/login/', array('email' => $email, 'password' => $password));

        if ($response->getStatusCode() === 200) $this->assertTrue($response->getData()->access_token !== null);

        else ($response->assertStatus(200));
    }
}
