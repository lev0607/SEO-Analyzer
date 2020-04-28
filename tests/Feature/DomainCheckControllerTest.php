<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DomainCheckControllerTest extends TestCase
{
    public function testChecks()
    {
        $html = file_get_contents('./tests/fixtures/test.html');
        $url = $this->faker->url;

        Http::fake([
            $url => Http::response($html, 200)
        ]);

        $currentDate = Carbon::now();

        $id = DB::table('domains')->insertGetId([
            'name' => $url,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);

        $response = $this->post(route('domains.checks', $id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domain_checks', [
            'id' => $id,
            'status_code' => 200,
            'h1' => 'This is h1',
            'keywords' => 'This is keywords',
            'description' => 'This is description'
        ]);
    }
}
