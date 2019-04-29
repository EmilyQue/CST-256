@extends('layouts.appmaster')
@section('title', 'Admin Page')

@section('content')

<h3>Here is what was found: </h3>
@if(count($jobPost) != 0) 
		@foreach($jobPost as $e)
		<hr>
		<u>{{$e->getJobTitle()}}</u><br/>
		Company: {{$e->getCompanyName()}}<br/>
		Date Posted: {{$e->getDatePosted()}}<br/>
<form action='job'><input type='hidden' name='id' value= '{{$e->getId()}}'><input type='submit' value='More Info'></form>
		@endforeach
@else
	No results found
	@endif
@endsection