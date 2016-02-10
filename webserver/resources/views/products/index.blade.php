@extends('layouts.default')

@section('title', '')

@section('content')
    <div class="container">
        <h2>Product overview</h2>
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
                        <td><a href="{{url('/products',$OwnLocation->product_id)}}">{{$OwnLocation->product_id}}</a></td>
                        <td>{{$OwnLocation->city}}</td>
                        <td>{{$OwnLocation->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {!! Form::open() !!}
    <div class="container">
        <h2>Product registration</h2>
        <table class="table">
            <tbody>
            <tr>
                <td><div class="form-group">
                        {!! Form::label('id','Product ID:') !!}
                        {!! Form::text('id',null, ['class' => 'form-control']) !!}
                    </div></td>
                <td><div class="form-group">
                        {!! Form::submit('Check',['class'=>'btn btn-primary form-control']) !!}
                    </div></td>
            </tr>
            </tbody>
        </table>
    </div>
    {!! Form::close() !!}
@endsection