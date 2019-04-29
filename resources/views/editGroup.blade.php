@extends('layouts.appmaster')
@section('title', 'Job History Page')

@section('content')
<!--- Profile Form --->
	<form action="groupUpdate" method="POST" style="background-color: #eaeaea;height: 300px;margin: 0px; width: 600px; border-radius: 10px">
		<input type="hidden" name="_token" value = "<?php echo csrf_token()?>">
	<br>
	
	@if(count($groups) != 0) 
	@foreach($groups as $group)
	<br/>
	<h3>Edit Group: </h3>
	<table>
	
	<tr>
	<td><input type="hidden" name="id" value='{{$group->getId()}}'/></td>
	</tr>
	
	<tr>
	<td>Group Name:</td>
	<td><input type="text" name="groupName" value='{{$group->getGroupName()}}'/>{{ $errors->first('groupName')}}</td>
	</tr>
	
	<tr>
	<td>Group Description:</td>
	<td><textarea rows="4" cols="50" name="groupDesc">{{$group->getGroupDescription()}}</textarea>{{ $errors->first('groupDesc')}}</td>
	</tr>
	
	<tr>
		<td colspan="2" align="center">
		<input type="submit" value="Submit"/></td>
	</tr> 
	</table>
	</form>
	@endforeach
	@endif
@endsection