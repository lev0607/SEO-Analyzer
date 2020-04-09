@extends('layouts.app')

@section('title', 'Page Analyzer')

@section('content')
    @if ($flash = session('status'))
         {{ $flash }}
    @endif
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{Form::open(['url' => route('domains.store')])}}
       {{Form::text('url')}}
       {{Form::submit('Click Me!')}}
    {{Form::close()}}
@endsection