<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use URL;

class DomainController extends Controller
{
    public function index()
    {
        $urls = DB::table('domains')->paginate(15);
        return view('domain.index', compact('urls'));
    }

    public function create()
    {
        return view('domain.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url|unique:domains,name'
        ]);

        $url = $request->input('url');
        $un = new URL\Normalizer($url);
        $normalizeUrl = $un->normalize();

        $currentDate = Carbon::now();

        DB::table('domains')->insertGetId([
            'name' => $normalizeUrl,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);

        session()->flash('status', 'Task was successful!');
        
        return redirect()->route('domains.create');
    }

    public function show($id)
    {
        $domain = DB::table('domains')->find($id);

        if (!$domain) {
            return abort(404);
        }

        return view('domain.show', compact('domain'));
    }
}
