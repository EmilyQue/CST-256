@extends('layouts.appmaster')
@section('title', 'Login Page')

@section('content')
<!--- Login Form --->

<body style="height: 422px;">
    <div class="login-dark" style="height: 616px;">
        <form action="login" method="POST" style="background-color: rgb(214,212,218);height: 421px;margin: 0px;">
        <input type="hidden" name="_token" value = "<?php echo csrf_token()?>">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline" style="color: rgb(117,84,186);"></i></div>
            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username">{{$errors->first('username')}}</div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password">{{$errors->first('password')}}</div>
            <div><input type="hidden" name="active"/></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: rgb(117,84,186);">Log In</button></div>
        </form>
    </div>
    <script src="resources/assets/js/jquery.min.js"></script>
    <script src="resources/assets/bootstrap/js/bootstrap.min.js"></script>

@endsection