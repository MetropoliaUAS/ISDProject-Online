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
            ->leftJoin("samplings", "samplings.sensor_id", "=", "sensors.id")
            ->selectRaw("`sensors`.`id`, `sensors`.`generic_sensor_id`, `sensors`.`product_id`, count(`samplings`.`id`) as `samplings_count`")
            ->groupBy("sensors.id")
            ->get();

        $userSensorsByProductIds = $userSensors->groupBy('product_id');
        return view('sensors.index', compact('userSensorsByProductIds'));
    }

    /**
     * Get a specific sensor
     */
    public function show($id)
    {
        $sensor = Sensor::find($id);
		/*
		$allsamplings = Sampling::all();
        $samplings = $allsamplings->filter(function($item) use ($id){
            return $item->sensor_id == $id;
        });
		*/
		$samplings = Sampling::where('sensor_id', '=', $id)
			->orderBy('created_at', 'asc')
			->get();
		
        if($sensor)
            return view('sensors.show', compact('sensor','samplings'));
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
