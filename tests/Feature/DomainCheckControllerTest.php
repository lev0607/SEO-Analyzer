<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DomainCheckControllerTest extends TestCase
{
    public function testStore()
    {    
        $url = $this->faker->url;

        Http::fake([
            $url => Http::response('Hello World', 200, ['Headers'])
        ]);

        $currentDate = Carbon::now();

        $id = DB::table('domains')->insertGetId([
            'name' => $url,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);

        $response = $this->post(route('domain_checks.store', $id));
        $response->assertStatus(302);
        $this->assertDatabaseHas('domain_checks', ['status_code' => 200]);
    }
}
