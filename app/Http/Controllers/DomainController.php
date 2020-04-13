<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use URL;

class DomainController extends Controller
{
    public function index()
    {

        $domains = DB::table('domain_checks')
            ->join('domains', 'domains.id', '=', 'domain_checks.domain_id')
            ->select('domains.id', 'domains.name', 'domain_checks.created_at', 'domain_checks.status_code')
            ->groupBy('domain_id')
            ->paginate(15);

        return view('domain.index', compact('domains'));
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
}
