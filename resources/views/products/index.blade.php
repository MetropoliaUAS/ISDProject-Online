@extends('layouts.default')

@section('title', '')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <h2>Product Overview</h2>
                @if(!count($OwnLocations))
                    <p>
                        So far you have not added a product to your account.
                        First make sure your device is connected to the internet.
                        Afterwards it will register itself to the server.
                        Then you can enter the <i>product ID</i> in the field below
                        and bind your product to your account.
                    </p>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>City</th>
                            <th>Added</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($OwnLocations as $OwnLocation)
                            <tr>
                                <td>
                                    <a href="{{url('/products',$OwnLocation->product_id)}}">{{$OwnLocation->product_id}}</a>
                                </td>
                                <td>{{$OwnLocation->city}}</td>
                                <td>{{$OwnLocation->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>


            <div class="col-md-6">
                <h2>Product Registration</h2>
                {!! Form::open() !!}
                <div class="form-group">
                    {!! Form::label('id','Product ID:') !!}
                    <input type="text" class="form-control" name="id" placeholder="ID" value="{{ old('id') }}">

                </div>
                <div class="form-group">
                    {!! Form::submit('Check',['class'=>'btn btn-primary form-control']) !!}
                </div>
                {!! Form::close() !!}
            </div>


        </div>
    </div>
@endsection