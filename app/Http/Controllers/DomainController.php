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
            ->whereIn(DB::raw('(domain_id, created_at)'), function ($query) {
                $query->select('domain_id', DB::raw('max(created_at)'))
                ->from('domain_checks')
                ->groupBy('domain_id');
            })
            ->orderBy('domain_id')
            ->get();

        $domains = DB::table('domains')->select('id', 'name')->get();

        $domainsData = $domains->map(function ($item, $key) use ($domain_checks) {
            $item->status_code = null;
            $item->created_at = null;
            if ($item_domain_checks = $domain_checks->firstWhere('domain_id', $item->id)) {
                $item->status_code = $item_domain_checks->status_code ?? null;
                $item->created_at = $item_domain_checks->created_at;
            }
            return $item;
        });
        return view('domain.index', compact('domainsData'));
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
            session()->flash('status', 'Url already exists!');
            return redirect()->route('domains.show', ['id' => $domain->id]);
        }

        $currentDate = Carbon::now();

        DB::table('domains')->insertGetId([
            'name' => $normalizeUrl,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);

        session()->flash('status', 'Task was successful!');
        
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
