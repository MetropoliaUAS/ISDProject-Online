@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email"  placeholder="Email Address" required="" autofocus="" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="Password" required=""/>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
                            </div>							
                        </div>
						
						<div class="form-group">
                            <div class="col-md-12">
                                If this is your first visit to our page you may
                                <b><a href="{{ url('/register') }}">register</a></b> to get access or did your
                                <a href="{{ url('/reset') }}">forget your password</a>?
                            </div>							
                        </div>
						
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
