<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
  </head>
  <body class="d-flex flex-column">
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Analyzer</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="   navbarNavAltMarkup"   aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-item nav-link @yield('home')" href="/">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link @yield('domains')" href="{{route('domains.index')}}">Domains</a>
          </div>
        </div>
      </nav>
    </header>
    <main class="flex-grow-1">
      @include('flash::message')
      @yield('content')
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>