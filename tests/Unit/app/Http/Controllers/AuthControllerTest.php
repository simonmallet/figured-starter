<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testGivenValidUserInformationWhenRegisterAPICalledThenUserIsCreated()
    {
        $response = $this->json('POST', route('api.register'), $this->getUser());

        $response->assertStatus(201);
    }

    public function testGivenWrongPasswordConfirmationWhenRegisterAPICalledThenErrorIsReturned()
    {
        $response = $this->json('POST', route('api.register'), $this->getUser(false));

        $response->assertStatus(422);
    }

    public function testGivenValidCredentialsWhenLoginThenStatusSuccess()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', route('api.authenticate'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function testGivenWrongCredentialsWhenLoginThenReturnsUnauthorized()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', route('api.authenticate'), [
            'email' => $user->email,
            'password' => 'wrong!',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Creates a mock user with valid/invalid password
     * @param bool $validPassword
     * @return array
     */
    private function getUser(bool $validPassword = true)
    {
        $user = factory(User::class)->make(['password' => 'secret1234']);
        return [
            'email' => $user->email,
            'name' => $user->name,
            'password' => $user->password,
            'password_confirmation' => ($validPassword) ? $user->password : 'wrong!',
        ];
    }
}
