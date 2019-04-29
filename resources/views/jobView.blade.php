@extends('layouts.appmaster')
@section('title', 'Admin Page')

@section('content')

@if(count($jobPosting) != 0) 
		@foreach($jobPosting as $e)
			<h3>{{$e->getJobTitle()}}</h3><br/>
			<h2>Details: </h2>
			<u>Company:</u> {{$e->getCompanyName()}}<br/>
			<u>Position:</u> {{$e->getPosition()}}<br/>
			<u>Job Description:</u> {{$e->getDescription()}}<br/>
			<u>Location:</u> {{$e->getCity()}}, {{$e->getState()}}<br/>
			<u>Date Posted:</u> {{$e->getDatePosted()}}<br/>
			<form action='applyJob'><input type='hidden' name='id' value={{$e->getID()}}><input type='submit' value='Apply'></form>
		@endforeach
	@endif


@endsection