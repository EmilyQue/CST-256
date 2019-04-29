@extends('layouts.appmaster')
@section('title', 'Profile Page')

@section('content')
<!--- Profile Form --->
<form action="updateContact" method="POST">
	<input type="hidden" name="_token" value="<?php echo csrf_token()?>"> <br>

@if(count($contactInfo) != 0) 
@foreach($contactInfo as $c)
	<br />
	<h3>Contact Information:</h3>

		<input type="hidden" name="id" value='{{$c->getId()}}'/>

		<label>Business Email: </label>
		<input type="email" name="business_email" value= '{{$c->getBusinessEmail()}}'/>{{ $errors->first('business_email')}}<br/>
		
		<label>Phone Number: </label>
		<input type="number" name="phone" value= '{{$c->getPhone()}}'/>{{ $errors->first('phone')}}<br/>
		
		<label>About Me: </label>
		<textarea rows="4" cols="50" name="aboutMe">{{$c->getAboutMe()}}</textarea>{{ $errors->first('aboutMe')}}<br/>
		
		<label>Street Address: </label>
		<input type="text" name="street" value= '{{$c->getStreetAddress()}}'/>{{ $errors->first('street')}}<br/>
		
		<label>City: </label>
		<input type="text" name="city" value= '{{$c->getCity()}}'/>{{ $errors->first('city')}}<br/>
		
		<label>State: </label>
		<input type="text" name="state" value= '{{$c->getState()}}'/>{{ $errors->first('state')}}<br/>
		
		<label>Zipcode: </label>
		<input type="number" name="zipcode" value= '{{$c->getZipcode()}}'/>{{ $errors->first('zipcode')}}<br/>
		
			<input type="submit" value="Submit" />

</form>
@endforeach
@endif
@endsection