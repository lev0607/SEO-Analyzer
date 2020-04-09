@extends('layouts.app')

@section('title', 'Page Analyzer')

@section('content')
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
 	{{Form::open(['url' => route('domains.store')])}}
 	   {{Form::submit('Run check!', ['class' => 'btn btn-primary'])}}
 	{{Form::close()}}
@endsection