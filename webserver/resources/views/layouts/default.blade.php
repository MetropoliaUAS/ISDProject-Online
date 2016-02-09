<html>
<head>
    <title>@yield('title')</title>
    @include('includes.head')
</head>
<body>
<div class="container">

	<div class="header">
		@include('includes.header')
	</div>
			
	<div class="nav-bar">	
		@if (Auth::user())
		<ul class="nav">
					<li><a href="/home">Home</a></li>
					<li><a href="/about">About</a></li>
					<li><a href="/profile">Profile</a></li>
					<li><a href="/sensors">Sensors</a></li>
					<li><a href="/products">Products</a></li>
					<li><a href="/logout">LOGOUT</a></li>
		</ul>		
	@else
		<ul class="nav">
					<i><a href="/">Home</a></i>
					<i><a href="/about">About</a></i>
		</ul>
	@endif
	</div>

    <div class="content">
		<div class="main">
			@if(Session::has('flash_message'))
				<div class="alert alert-success">{{Session::get('flash_message')}}</div>
			@endif
            @yield('content')			
		</div>
    </div>

	<div class="footer">
		@include('includes.footer')
	</div>
	
</div>
</body>
</html>

	