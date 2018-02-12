<?php


use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public $dados = [];
    public $api_token = [];
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dados = [
            'name' => 'Nome 01'.date('Ymdis').' '.rand(1,100),
            'email' => 'email'.date('Ymdis').'_'.rand(1,100).'3@exemplo.com',
            'password' => '123',
            'password_confirmation' => '123'
        ];

        $this->api_token = ['api_token' => \App\User::where('api_token','<>','')->first()->api_token];

    }

    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCreateUser()
    {


        $this->post('/api/user',$this->dados,$this->api_token);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());

        $this->assertArrayHasKey('name',$resposta);
        $this->assertArrayHasKey('email',$resposta);
        $this->assertArrayHasKey('id',$resposta);

        $this->seeInDatabase('users',[
            'name' => $this->dados['name'],
            'email' => $this->dados['email']
        ]);

    }

    public function testViewUser()
    {
        $user = \App\User::first();
        $this->get('/api/user/'.$user->id,$this->api_token);
        $this->assertResponseOk();
        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name',$resposta);
        $this->assertArrayHasKey('email',$resposta);
        $this->assertArrayHasKey('id',$resposta);
    }





    public function testeLogin(){

        $this->post('/api/user',$this->dados,$this->api_token);
        $this->assertResponseOk();

        $this->post('/api/login',$this->dados);
        $this->assertResponseOk();
        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('api_token',$resposta);




    }




    public function testAllUser()
    {

        $this->get('/api/users',$this->api_token);
        $this->assertResponseOk();
        $this->seeJsonStructure([
            '*' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }


    public function testDeleteUser()
    {
        $user = \App\User::first();
        $this->delete('/api/user/'.$user->id,$this->api_token);
        $this->assertResponseOk();
        $this->assertEquals("Removido com sucesso!",$this->response->content());
    }


    public function testUpdateUserNoPassword()
    {
        $user = \App\User::first();
        $dados = [
            'name' => 'Nome 01'.date('Ymdis').' '.rand(1,100),
            'email' => 'email4_'.date('Ymdis').'_'.rand(1,100).'@exemplo.com',
        ];

        $this->put('/api/user/'.$user->id,$dados,$this->api_token);
        $this->assertResponseOk();
        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name',$resposta);
        $this->assertArrayHasKey('email',$resposta);
        $this->assertArrayHasKey('id',$resposta);
        $this->notSeeInDatabase('users',[
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id
        ]);

    }



    public function testUpdateUserWithPassword()
    {
        $user = \App\User::first();
        $dados = [
            'name' => 'Nome 01'.date('Ymdis').' '.rand(1,100),
            'email' => 'email4_'.date('Ymdis').'_'.rand(1,100).'@exemplo.com',
            'password' => '123',
            'password_confirmation' => '123'
        ];

        $this->put('/api/user/'.$user->id,$dados,$this->api_token);
        $this->assertResponseOk();
        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name',$resposta);
        $this->assertArrayHasKey('email',$resposta);
        $this->assertArrayHasKey('id',$resposta);
        $this->notSeeInDatabase('users',[
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id
        ]);

    }




}
