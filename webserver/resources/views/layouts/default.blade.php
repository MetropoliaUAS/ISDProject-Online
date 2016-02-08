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
					<a href="/home">Home</a>
					<a href="/about">About</a>	
					<a href="/profile">Profile</a>
					<a href="/measurements">Measurements</a>
					<a href="/products">Products</a>
					<a href="/logout">LOGOUT</a>
		</ul>		
	@else
		<ul class="nav">
					<a href="/">Home</a>
					<a href="/about">About</a>					
		</ul>
	@endif
	</div>

    <div class="content">
		<div class="main">
            @yield('content')			
		</div>
    </div>

	<div class="footer">
		@include('includes.footer')
	</div>
	
</div>
</body>
</html>

	