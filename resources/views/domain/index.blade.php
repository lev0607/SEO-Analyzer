@extends('layouts.app')

@section('title', 'Page Analyzer')

@section('content')
    @foreach ($domains as $domain)
        <h2><a href="{{ route('domains.show', ['id' => $domain->id]) }}">{{$domain->name}}</a><span>{{$domain->created_at}}</span></h2>

    @endforeach
    {{ $domains->links() }}
@endsection