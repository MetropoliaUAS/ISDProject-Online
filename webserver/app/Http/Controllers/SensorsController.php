<?php

namespace App\Http\Controllers;

use App\GenericSensor;
use App\Product;
use App\Sampling;
use App\Sensor;
use App\Location;
use Request;
use Auth;
use App\Http\Requests\ProductCreationRequest;
use Illuminate\Support\Collection;

class SensorsController extends Controller
{

    public function getUserLocations()
    {
        $user_id = Auth::User()->id;
        $UserLocations = Location::where('user_id', $user_id)->get();
        return $UserLocations;
    }

    public function getUserProducts($LocationCollection)
    {
        $UserProducts = collect();
        foreach($LocationCollection as $location)
        {
            $UserProducts->push( Product::find($location->product_id));
        }
        return $UserProducts;
    }

    public function getUserSensors($ProductCollection)
    {
        $UserSensors = collect();
        foreach($ProductCollection as $product)
        {
            $UserSensors->push(Sensor::where('product_id',$product->id)->get());
        }
        return $UserSensors;
    }

    /**
     * Get the sensors of all registered products for the current user
     */
    public function index()
    {
        $UserLocations = $this->getUserLocations();
        $UserProducts = $this->getUserProducts($UserLocations);
        $UserSensors = $this->getUserSensors($UserProducts);
        return view('sensors.index', compact('UserSensors'));
    }

    /**
     * Get a specific sensor
     */
    public function show($id)
    {
        $sensor = Sensor::find($id);
        $allsamplings = Sampling::all();
        $samplings = $allsamplings->filter(function($item) use ($id){
            return $item->sensor_id == $id;
        });

        if($sensor)
            return view('sensors.show',compact('sensor'),compact('samplings'));
        else
            return 'kein Treffer gefunden für: '. $id . ' ';
    }

    /**
     * Get a list of sensor types and informations
     */
    public function show_types($id)
    {
        $AllSensorTypes = collect(GenericSensor::All());
        $SensorID = $id;
        return view('sensors.types',compact('AllSensorTypes'),compact('SensorID'));
    }



}
