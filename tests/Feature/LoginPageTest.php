<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginPageTest extends TestCase
{
    public function test_login_page_uses_the_proklim_admin_design_and_keeps_the_login_form_contract(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Selamat Datang')
            ->assertSee('DLHK PROKLIM')
            ->assertSee('Masukkan email')
            ->assertSee('Masukkan password')
            ->assertSee('Ingat informasi masuk')
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="remember"', false)
            ->assertSee('action="'.route('login-process').'"', false)
            ->assertSee('class="password-toggle"', false);
    }

    public function test_login_form_still_uses_server_side_validation(): void
    {
        $this->from('/login')
            ->post('/login', [])
            ->assertRedirect('/login')
            ->assertSessionHasErrors(['email', 'password']);
    }
}
