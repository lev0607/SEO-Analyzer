@extends('layouts.app')

@section('title', 'Page Analyzer')

@section('content')
    @foreach ($urls as $url)
        <h2><a href="{{ route('domains.show', ['id' => $url->id]) }}">{{$url->name}}</a></h2>
    @endforeach
@endsection