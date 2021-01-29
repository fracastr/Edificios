<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCreate()
    {
        $data = $this->getData();
        // Creamos un nuevo usuario y verificamos la respuesta
        $this->post('api/user', $data)
            ->assertStatus(201);

        $data = $this->getData(['name' => 'jane']);
        // Actualizamos al usuario recien creado (id = 1)
        $this->put('api/user/1', $data)
            ->assertStatus(200);

        // Eliminamos al usuario
        $this->delete('api/user/1')->assertStatus(200);
    }

    public function getData($custom = array())
    {
        $data = [
            'name'      => 'joe',
            'email'     => 'joe@doe.com',
            'password'  => '12345'
            ];
        $data = array_merge($data, $custom);
        return $data;
    }
}
