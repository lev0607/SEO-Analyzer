@extends('layouts.app')

@section('title', 'Page Analyzer')

@section('content')
    @if ($flash = session('status'))
         {{ $flash }}
    @endif
    <h2>{{$domain->name}}</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <td>id</td>
                <td>{{$domain->id}}</td>
            </tr>
            <tr>
                <td>name</td>
                <td>{{$domain->name}}</td>
            </tr>
            <tr>
                <td>created_at</td>
                <td>{{$domain->created_at}}</td>
            </tr>
            <tr>
                <td>updated_at</td>
                <td>{{$domain->updated_at}}</td>
            </tr>
        </table>
    </div>
    <h2 class="mt-5 mb-3">Checks</h2>
 	{{Form::open(['url' => route('domain_checks.store', ['id' => $domain->id])])}}
 	   {{Form::submit('Run check!', ['class' => 'btn btn-primary'])}}
 	{{Form::close()}}
 	@isset($domain_checks)
    	@foreach ($domain_checks as $domain_check)
    	    <h6>{{$domain_check->id}}</h6>
            <h6>{{$domain_check->status_code}}</h6>
            <h6>{{$domain_check->h1}}</h6>
            <h6>{{$domain_check->description}}</h6>
            <h6>{{$domain_check->keywords}}</h6>
    	    <p>{{$domain_check->created_at}}</p>
    	@endforeach
    @endisset
@endsection