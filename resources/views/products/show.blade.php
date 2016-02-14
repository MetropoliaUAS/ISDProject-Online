@extends('layouts.default')

@section('title', '')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                {!! Form::open(['url'=>'products/'. $product->location->id]) !!}
                <h2>Product {{$product->id}}</h2>
                <table class="table">
                    <tbody>
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
                {!! Form::close() !!}

                <div class="form-group">
                    {!! Form::open(['url'=>'products/delete/'. $product->location->id]) !!}
                    {!! Form::submit('Delete',['class'=>'btn btn-primary form-control']) !!}
                    {!! Form::close() !!}
                </div>
                <div class="form-group">
                    <a href="{{ url('products') }}" class="btn btn-primary form-control">Back</a>
                </div>
            </div>


        </div>
    </div>
@endsection