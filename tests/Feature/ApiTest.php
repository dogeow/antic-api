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
        $this->get('/md5/admin')
            ->assertStatus(200)
            ->assertSee('21232f297a57a5a743894a0e4a801fc3');
    }

    /**
     * @return void
     */
    public function test_ip()
    {
        $this->get('/ip')
            ->assertStatus(200)
            ->assertSee('127.0.0.1');
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
        $this->get('/hash/admin')
            ->assertStatus(200)
            ->assertSee('d033e22ae348aeb5660fc2140aec35850c4da997');
    }

    public function test_user_agent()
    {
        $this->get('/user-agent')
            ->assertStatus(200)
            ->assertSee('Symfony');
    }

    public function test_keyword()
    {
        $response = $this->get('/keywords/我的世界');

        $response->assertStatus(200);

        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true, JSON_UNESCAPED_UNICODE);

        $this->assertContains('世界', array_keys($data));
    }
}
