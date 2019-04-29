@extends('layouts.appmaster')
@section('title', 'Profile Success Page')

@section('content')

<hr>

<h3>Groups Joined: </h3>
@if(count($userGroup) != 0) 
		@foreach($userGroup as $g)
			Group ID: {{$g->getGroup_id()}} <br/>
			<form action='leaveGroup'><input type='hidden' name='id' value={{$g->getGroup_id()}}><input type='submit' value='Leave'></form>
		@endforeach
		@else
		<p>You haven't joined any groups</p>
@endif
@endsection
