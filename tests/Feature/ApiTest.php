<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_md5()
    {
        $response = $this->get('/md5/admin');

        $response->assertStatus(200);

        $response->assertSee('21232f297a57a5a743894a0e4a801fc3');
    }

    /**
     * @return void
     */
    public function test_ip()
    {
        $response = $this->get('/ip');

        $response->assertStatus(200);

        $response->assertSee('127.0.0.1');
    }

    public function test_ip_api()
    {
        $response = $this->getJson('/ip/127.0.0.1', [
            'timeout' => '2',
        ]);

        $response->assertStatus(200);

        // 国内访问问，偶尔访问慢，不报错
        if (empty($response->getContent())) {
            return;
        }

        $this->assertJson($response->getContent());

        $response->assertJsonFragment([
            'status' => 'fail',
        ]);
    }

    public function test_hash()
    {
        $response = $this->get('/hash/admin');

        $response->assertStatus(200);

        $response->assertSee('d033e22ae348aeb5660fc2140aec35850c4da997');
    }

    public function test_user_agent()
    {
        $response = $this->get('/user-agent');

        $response->assertStatus(200);

        $response->assertSee('Symfony');
    }

    public function test_keyword()
    {
        $response = $this->get('/keywords/我的世界');

        $response->assertStatus(200);

        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), JSON_UNESCAPED_UNICODE);

        $this->assertContains('世界', array_keys($data));
    }
}
