<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DiDom\Document;

class DomainCheckController extends Controller
{
    public function store($id)
    {
        $domain = DB::table('domains')->find($id);

        if (!$domain) {
            Log::info("domains.id - {$id} not found");
            return abort(404);
        }

        try {
            $response = Http::get($domain->name);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            session()->flash('status error', 'Something was wrong!');
            return back();
        }

        $statusCode = $response->getStatusCode();

        $document = new Document($response->body());

        $h1 = optional($document->first('h1'))->text();
        $description = optional($document->first('meta[name="description"]'))->attr('content');
        $keywords = optional($document->first('meta[name="keywords"]'))->attr('content');

        $currentDate = Carbon::now();

        DB::table('domain_checks')->insertGetId([
            'domain_id' => $id,
            'status_code' => $statusCode,
            'h1' => $h1,
            'keywords' => $keywords,
            'description' => $description,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);

        session()->flash('status', 'Website has been checked!');

        return back();
    }
}
