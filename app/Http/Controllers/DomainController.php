<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
	// protected $fillable = ['name', 'body'];

    public function index()
    {
        $urls = DB::table('domains')->get();
        return view('domain.index', compact('urls'));
    }

    public function create()
    {
        return view('domain.create');
    }

    public function store(Request $request)
    {
        // Проверка введённых данных
        // Если будут ошибки, то возникнет исключение
        // Иначе возвращаются данные формы
        $url = $request->input('url');
        $data = $this->validate($request, [
            'url' => 'required'
        ]);

		$currentDate = Carbon::now();

		DB::table('domains')->insertGetId([
			'name' => $url,
            'created_at' => $currentDate,
            'updated_at' => $currentDate
		]);

        session()->flash('status', 'Task was successful!');
        
        return redirect()->route('domains.create');
    }

    public function show($id)
    {
        $url = DB::table('domains')->find($id);
        return view('domain.show', compact('url'));
    }
}
