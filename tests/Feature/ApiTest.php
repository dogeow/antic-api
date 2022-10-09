<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * md5 查询
     */
    public function test_md5()
    {
        $this->get('/md5/admin')
            ->assertStatus(200)
            ->assertSee('21232f297a57a5a743894a0e4a801fc3');
    }

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

    /**
     * 查询 User-Agent
     */
    public function test_user_agent()
    {
        $this->get('/user-agent')
            ->assertStatus(200)
            ->assertSee('Symfony');
    }

    /**
     * 关键词提取
     */
    public function test_keyword()
    {
        $response = $this->get('/keywords/我的世界');

        $response->assertStatus(200);

        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true, JSON_UNESCAPED_UNICODE);

        $this->assertArrayHasKey('世界', $data);
    }

    /**
     * 获取网址标题
     */
    public function test_url_title()
    {
        $response = $this->get('/url-title?url=https://www.example.com');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => 'Example Domain',
        ]);
    }

    /**
     * 银行卡信息
     */
    public function test_bankcard()
    {
        $response = $this->get('/bankcard/6228480402564890018');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'stat' => 'ok',
        ]);
    }

    /**
     * 查询时间戳
     */
    public function test_timestamp()
    {
        $response = $this->get('/timestamp');
        $response->assertStatus(200);
        $this->assertEquals(time(), $response->getContent());
    }

    /**
     * 日期时间转时间戳
     */
    public function test_to_date_timestamp()
    {
        $response = $this->get('/timestamp/2020-09-13 20:26:40');
        $response->assertStatus(200);
        $this->assertEquals('1600000000', $response->getContent());
    }

    /**
     * 查询日期
     */
    public function test_date()
    {
        $response = $this->get('/date');
        $response->assertStatus(200);
        $this->assertEquals(date('Y-m-d'), $response->getContent());
    }

    /**
     * 时间戳转日期
     */
    public function test_timestamp_to_date()
    {
        $response = $this->get('/date/1600000000');
        $response->assertStatus(200);
        $this->assertEquals('2020-09-13', $response->getContent());
    }

    public function test_image_download()
    {
        $response = $this->get('/image/download');
        $response->assertStatus(200);
        $this->assertStringContainsString('image', $response->headers->get('Content-Type'));
        $this->assertGreaterThan(0, $response->headers->get('Content-Length'));
    }

    public function test_punycode()
    {
        $response = $this->get('/punycode/中文.com');
        $response->assertStatus(200);
        $this->assertStringContainsString('xn--fiq228c.com', $response->getContent());
    }
}
