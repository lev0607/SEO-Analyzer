@extends('layouts.app')

@section('title', 'Page Analyzer')

@section('content')
    @if ($flash = session('status'))
         {{ $flash }}
    @endif
    {{Form::open(['url' => route('domains.store')])}}
       {{Form::text('url')}}
       {{Form::submit('Click Me!')}}
    {{Form::close()}}
@endsection