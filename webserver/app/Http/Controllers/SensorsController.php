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
        $user_id = Auth::user()->id;
        $AllLocations = collect(Location::all());
        $UserLocations = $AllLocations->where('user_id',$user_id);
        return $UserLocations;
    }

    public function getUserProducts($LocationCollection)
    {
        $AllProducts = collect(Product::all());
        $UserProducts = collect();
        foreach($LocationCollection as $location)
        {
            $UserProducts->push($AllProducts->where('id',$location->product_id));
        }
        return $UserProducts;
    }

    public function getUserSensors($ProductCollection)
    {
        $AllSenors = collect(Sensor::all());
        $UserSensors = collect();
        foreach($ProductCollection as $product)
        {
            $UserSensors->push($AllSenors->where('product_id',$product->id));
        }
        return $UserSensors;
    }

    /**
     * Get the sensors of all registered products for the current user
     */
    public function index()
    {
        //$UserLocations = $this->getUserLocations();
        //$UserProducts = $this->getUserProducts($UserLocations);
        //return $UserProducts; //TODO: why is there ANOTHER  BRACKET around and NUMBER infront of the Product
        //$UserSensors = $this->getUserSensors($UserProducts);

        $UserSensors = Sensor::all();
        $UserProducts = Product::all();
        return view('sensors.index', compact('UserProducts'),compact('UserSensors'));
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
    public function show_types()
    {
        $AllSensorTypes = collect(GenericSensor::All());
        return view('sensors.types',compact('AllSensorTypes'));
    }



}
