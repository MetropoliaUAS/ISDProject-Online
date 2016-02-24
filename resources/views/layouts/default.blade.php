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

    <nav class="navbar navbar-default" role="navigation">
        @if (Auth::user())
            <ul class="nav navbar-nav navbar-left">
                <li><a href="/home">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/profile">Profile</a></li>
                <li><a href="/sensors">Sensors</a></li>
                <li><a href="/products">Products</a></li>
                <li><a href="/dashboard">Dashboard</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/logout">Logout</a></li>
            </ul>
        @else
            <ul class="nav navbar-nav navbar-left">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
            </ul>
        @endif
    </nav>


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
@yield('jslib')
</body>
</html>

	