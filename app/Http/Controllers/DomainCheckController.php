<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DomainCheckController extends Controller
{
    public function store(Request $request, $id)
    {

        $currentDate = Carbon::now();

        DB::table('domain_checks')->insertGetId([
            'domain_id' => $id,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
        ]);

        session()->flash('status', 'Website has been checked!');

        return back();
    }
}
