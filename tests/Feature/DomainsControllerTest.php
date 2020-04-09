<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DomainsControllerTest extends TestCase
{
    protected $validUrl = ['url' => 'https://hexlet.io/'];
    protected $invalidUrl = ['url' => 'hexlet.io/'];

    public function testCreate()
    {
        $response = $this->get(route('domains.create'));
        $response->assertStatus(200);
    }

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $this->post(route('domains.store'), $this->validUrl);
        $this->assertDatabaseHas('domains', ['name' => $this->validUrl['url']]);

        $this->post(route('domains.store'), $this->invalidUrl);
        $this->assertDatabaseMissing('domains', ['name' => $this->invalidUrl['url']]);
    }

    public function testShow()
    {
        $this->post(route('domains.store'), $this->validUrl);
        $response = $this->get(route('domains.show', ['id' => 1]));
        
        $this->assertStringContainsString($this->validUrl['url'], $response->getContent());
    }
}
