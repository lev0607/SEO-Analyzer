<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            $res = $response->getStatusCode();
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            session()->flash('status', 'Something was wrong!');
            return back();
        }

        $currentDate = Carbon::now();

        DB::table('domain_checks')->insertGetId([
            'domain_id' => $id,
            'status_code' => $res,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);

        session()->flash('status', 'Website has been checked!');

        return back();
    }
}
