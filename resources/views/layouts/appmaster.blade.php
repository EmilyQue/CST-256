<html lang="en">
<head>
<title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="resources/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="resources/assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Barlow:300,400,500,600,700,900,900i">
    <link rel="stylesheet" href="resources/assets/css/Contact-form-1.css">
    <link rel="stylesheet" href="resources/assets/css/Contact-form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="resources/assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="resources/assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="resources/assets/css/Profile-Picture-With-Badge.css">
    <link rel="stylesheet" href="resources/assets/css/styles.css">
    </head>
<body>
	@include('layouts.header')
	<div align="center">
		@yield('content')
	</div>
	@include('layouts.footer')
	
</body>