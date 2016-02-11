@extends('layouts.default')

@section('title', '')

@section('content')

    {!! Form::open(['url'=>'products/'. $product->location->id]) !!}
    <div class="container">
        <h2>Product {{$product->id}}</h2>
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
                        {!! Form::text('product_id', $product->location->product_id, ['readonly'], ['class' => 'form-control'] ) !!}
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
                        {!! Form::text('address', $product->location->address, ['class' => 'form-control']) !!}
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
                        {!! Form::text('zip', $product->location->zip, ['class' => 'form-control']) !!}
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
                        {!! Form::text('city', $product->location->city, ['class' => 'form-control']) !!}
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
                        {!! Form::text('country_code', $product->location->country_code, ['class' => 'form-control']) !!}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="form-group">
            {!! Form::submit('Update',['class'=>'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url'=>'products/delete/'. $product->location->id]) !!}
    <div class="form-group">
        {!! Form::submit('Delete',['class'=>'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}

@endsection