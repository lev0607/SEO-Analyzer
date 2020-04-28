<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DomainsControllerTest extends TestCase
{

    public function testCreate()
    {
        $response = $this->get(route('domains.create'));
        $response->assertOk();
    }

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $url = $this->faker->url;
        $response = $this->post(route('domains.store'), ['url' => $url]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', ['name' => $url]);
    }

    public function testShow()
    {
        $url = $this->faker->url;
        $this->post(route('domains.store'), ['url' => $url]);
        $response = $this->get(route('domains.show', ['id' => 1]));
        
        $this->assertStringContainsString($url, $response->getContent());
    }
}
