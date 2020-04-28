<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DiDom\Document;
use URL;

class DomainController extends Controller
{
    public function index()
    {
        $domain_checks = DB::table('domain_checks')
            ->select('domain_id', 'status_code', 'created_at')
            ->orderBy('domain_id')
            ->oldest()
            ->get()
            ->keyBy('domain_id');

        $domains = DB::table('domains')->select('id', 'name')->get();

        return view('domain.index', compact('domains', 'domain_checks'));
    }


    public function create()
    {
        return view('domain.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = $request->input('url');
        $un = new URL\Normalizer($url);
        $normalizeUrl = $un->normalize();

        $domain = DB::table('domains')->where('name', $normalizeUrl)->first();

        if ($domain) {
            flash('Url already exists!')->success();
            return redirect()->route('domains.show', ['id' => $domain->id]);
        }

        $currentDate = Carbon::now();

        DB::table('domains')->insertGetId([
            'name' => $normalizeUrl,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);

        flash('Task was successful!')->success();
        
        $domain = DB::table('domains')->latest()->first();

        return redirect()->route('domains.show', ['id' => $domain->id]);
    }

    public function show($id)
    {
        $domain = DB::table('domains')->find($id);
        $domain_checks = DB::table('domain_checks')->where('domain_id', $id)->latest()->get();

        if (!$domain) {
            Log::info("domains.id - {$id} not found");
            return abort(404);
        }

        return view('domain.show', compact('domain', 'domain_checks'));
    }

    public function checks($id)
    {
        $domain = DB::table('domains')->find($id);

        if (!$domain) {
            Log::info("domains.id - {$id} not found");
            return abort(404);
        }

        try {
            $response = Http::get($domain->name);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::info($e->getMessage());
            flash('This site can’t be reached. Server IP address could not be found!')->error();
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

        flash('Website has been checked!')->success();

        return back();
    }
}
