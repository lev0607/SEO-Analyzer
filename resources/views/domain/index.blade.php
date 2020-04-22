@extends('layouts.app')

@section('title', 'Page Analyzer')
@section('domains', 'active')

@section('content')
<div class="container-lg">
	<div class="row">
		<h1 class="mt-5 mb-3">Domains</h1>
		<div class="table-responsive">
			<table class="table table-bordered table-hover text-nowrap">
				<thead class="thead-dark">
					<tr>
		        	    <th>ID</th>
		        	    <th>Name</th>
		        	    <th>Status code</th>
		        	    <th>Created at</th>
		        	</tr>
		    	</thead>
		    @foreach ($domains as $domain)
		    	<tr>
		    		<td>{{$domain->id}}</td>
		        	<td><a href="{{ route('domains.show', ['id' => $domain->id]) }}">{{$domain->name}}</a></td>
		        	<td>{{$domain_checks->get($domain->id) ? $domain_checks->get($domain->id)->status_code : ""}}</td>
					<td>{{$domain_checks->get($domain->id) ? $domain_checks->get($domain->id)->created_at : ""}}</td>
		        </tr>
		    @endforeach
		    </table>
		</div>
	</div>
</div>
@endsection