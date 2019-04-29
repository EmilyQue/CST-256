@extends('layouts.appmaster')
@section('title', 'Admin Page')

@section('content')

@if(count($groups) != 0) 
		@foreach($groups as $e)
		<h3>Group Details: </h3>
			<a>{{$e->getGroupName()}}</a><br/>
			<a>{{$e->getGroupDescription()}}</a><br/>
			
			<form action='joinGroup'><input type='hidden' name='id' value={{$e->getId()}}><input type='submit' value='Join'></form>
		@endforeach
	@endif

@endsection