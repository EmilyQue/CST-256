@extends('layouts.appmaster')
@section('title', 'Profile Success Page')

@section('content')

<hr>

<h3>Groups Joined: </h3>
<form action='joinGroup'><input type='hidden' name='id' ><input type='submit' value='Join'></form>
    
@endsection