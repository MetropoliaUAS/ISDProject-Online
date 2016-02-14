@extends('layouts.default')

@section('title', '')

@section('content')

    {!! Form::open(['url'=>'products/add']) !!}
    <div class="container">
        <h2> Add a product {{$product->id}} to your profile</h2>
        <table class="table">
            <tbody>
            <tr>
                <td>
                    <div class="form-group">
                        {!! Form::label('product_id','Product ID:') !!}
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::text('product_id',$product->id, ['class' => 'form-control', 'readonly' => 'true'] ) !!}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        {!! Form::label('address','Address:') !!}
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::text('address',null, ['class' => 'form-control']) !!}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        {!! Form::label('zip','Zip:') !!}
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::text('zip',null, ['class' => 'form-control']) !!}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        {!! Form::label('city','City:') !!}
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::text('city',null, ['class' => 'form-control']) !!}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        {!! Form::label('country_code','Country Code:') !!}
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::text('country_code',null, ['class' => 'form-control']) !!}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="form-group">
            {!! Form::submit('Add',['class'=>'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection