@extends('layouts.appmaster')
@section('title', 'Registration Page')

@section('content')
<!--- Login Form --->
 <div class="login-dark" style="height: 616px;">
        <form action="register" method="POST" style="background-color: rgb(214,212,218);height: 540px;margin: 0px;">
        <input type="hidden" name="_token" value = "<?php echo csrf_token()?>">
            <h2 class="sr-only">Register Form</h2>
            <div class="illustration"><i class="icon ion-android-person-add" style="color: rgb(117,84,186);"></i></div>
            <div class="form-group"><input class="form-control" type="text" name="firstname" placeholder="First Name">{{ $errors->first('firstname')}}</div>
            <div class="form-group"><input class="form-control" type="text" name="lastname" placeholder="Last Name" style="height: 36px;margin-bottom: 10px;">{{ $errors->first('lastname')}}<input class="form-control" type="email" name="email" placeholder="Email" style="margin-bottom: 10px;">{{ $errors->first('email')}}
                <input
                    class="form-control" type="text" name="username" placeholder="Username" style="margin-bottom: 10px;">{{ $errors->first('username')}}<input class="form-control" type="password" name="password" placeholder="Password" style="margin-bottom: 10px;">{{ $errors->first('password')}}</div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: rgb(117,84,186);margin-bottom: 0;margin-top: 25px;">Sign Up</button></div>
        </form>
    </div>
    <script src="resources/assets/js/jquery.min.js"></script>
    <script src="resources/assets/bootstrap/js/bootstrap.min.js"></script>
@endsection