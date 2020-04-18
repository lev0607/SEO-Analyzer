@extends('layouts.app')

@section('title', 'Page Analyzer')

@section('content')
<div class="container-lg">
    @if ($flash = session('status'))
        <div class="alert alert-success" role="alert">
             {{ $flash }}
        </div>
    @endif
    @if ($flash = session('status error'))
        <div class="alert alert-danger" role="alert">
             {{ $flash }}
        </div>
    @endif
    <h2>Site: {{$domain->name}}</h2>
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
    <div style="margin-bottom: 10px;">
        <h2 class="mt-5 mb-3">Checks</h2>
        {{Form::open(['url' => route('domain_checks.store', ['id' => $domain->id])])}}
            {{Form::submit('Run check!', ['class' => 'btn btn-info'])}}
        {{Form::close()}}
    </div>
 	@isset($domain_checks)
        <div class="table-responsive">
            <table class="table table-bordered  table-hover">
        	@foreach ($domain_checks as $domain_check)
                <tr class="table-active">
                    <td>id</td>
                    <td>{{$domain_check->id}}</td>
                </tr>
                <tr>
                    <td>status code</td>
                    <td>{{$domain_check->status_code}}</td>
                </tr>
                <tr>
                    <td>h1</td>
                    <td>{{$domain_check->h1}}</td>
                </tr>
                <tr>
                    <td>description</td>
                    <td>{{$domain_check->description}}</td>
                </tr>
                <tr>
                    <td>keywords</td>
                    <td>{{$domain_check->keywords}}</td>
                </tr>
                <tr>
                    <td>created_at</td>
        	       <td>{{$domain_check->created_at}}</td>
                </tr>
        	@endforeach
            </table>
        </div>    
    @endisset
</div>
@endsection