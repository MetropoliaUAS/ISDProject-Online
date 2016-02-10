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

    /**
     * Get the sensors of all registered products for the current user
     */
    public function index()
    {
        $userSensors = Auth::user()->sensors()
            ->with("genericSensor")
            ->get(["sensors.id", "generic_sensor_id", "sensors.product_id"]);
        return view('sensors.index', compact('userSensors'));
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