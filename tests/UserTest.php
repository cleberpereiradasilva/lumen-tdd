<?php


use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCreateUser()
    {
        $dados = [
          'name' => 'Nome 01',
          'email' => 'email3@exemplo.com',
          'password' => '123'
        ];

        $this->post('/api/user',$dados);

        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());

        $this->assertArrayHasKey('name',$resposta);
        $this->assertArrayHasKey('email',$resposta);
        $this->assertArrayHasKey('id',$resposta);

    }

    public function testViewUser()
    {
        $user = \App\User::first();
        $this->get('/api/user/'.$user->id);
        $this->assertResponseOk();
        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name',$resposta);
        $this->assertArrayHasKey('email',$resposta);
        $this->assertArrayHasKey('id',$resposta);

    }

}
