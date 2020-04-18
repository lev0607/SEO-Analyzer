@extends('layouts.app')

@section('title', 'Page Analyzer')
@section('home', 'active')

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <div class="jumbotron jumbotron-fluid">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto">
                    <h1 class="display-5">Page Analyzer</h1>
                    <p class="lead">Check web pages for free</p>
                    {{Form::open(['url' => route('domains.store'),'class' => 'd-flex justify-content-center'])}}
                       {{Form::text('url', null, ['class' => 'form-control form-control-lg', 'placeholder' =>   'https://www.example.com'])}}
                       {{Form::submit('Check!', ['class' => 'btn btn-lg btn-info ml-3 px-5 text-uppercase'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection