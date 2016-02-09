<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSamplingsRequest;
use App\Http\Requests\ShowingSamplingsRequest;
use App\Product;
use App\Sampling;
use App\Sensor;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SamplingsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSamplingsRequest $request)
    {
        $samplings_groupBy_gsIds = collect($request->samplings)->groupBy('generic_sensor_id');
        /**
         * for querying the sensors, we remove any object that didn't have a "generic_sensor_id" field
         *
         * Parameters:
         * "samplings": [
         *     {
         *         "generic_sensor_id": 2,
         *         "value": 49.72
         *     },
         *     {
         *         "generic_sensor_id": 3,
         *         "value": 104.693
         *     },
         *     {
         *         "generic_sensor_id": 4,
         *         "value": 22.1
         *     },
         *     {
         *         "generic": 1
         *     }
         * ]
         *
         *
         * After group:
         * {
         *     "2": [
         *         {
         *             "generic_sensor_id": 2,
         *             "value": 49.72
         *         }
         *     ],
         *     "3": [
         *         {
         *             "generic_sensor_id": 3,
         *             "value": 104.693
         *         }
         *     ],
         *     "4": [
         *         {
         *             "generic_sensor_id": 4,
         *             "value": 22.1
         *         }
         *     ],
         *     "": [
         *         {
         *             "generic": 1
         *         }
         *     ]
         * }
         */
        $samplings_groupBy_gsIds->forget("");

        $sensors =
            Sensor::join('generic_sensors', 'sensors.generic_sensor_id', '=', 'generic_sensors.id')
            ->join('products', 'sensors.product_id', '=', 'products.id')
            ->whereIn('generic_sensors.id', $samplings_groupBy_gsIds->keys())
            ->where('products.id', $request->product_id)
            ->get(['sensors.id', 'sensors.generic_sensor_id']);

        $sensor_for_gsId = array();
        foreach ($sensors as $sensor) {
            $sensor_for_gsId[$sensor->generic_sensor_id] = $sensor->getKey();
        }

        $newSamplings = array();
        $today = Carbon::now();
        foreach ($request->samplings as $sampling) {
            if (! array_has($sampling, 'generic_sensor_id') || ! array_has($sampling, 'value')) continue;

            $created_at = $today;
            if (array_has($sampling, 'created_at') && strtotime($sampling['created_at'])) {
                $created_at = Carbon::createFromTimestamp(strtotime($sampling['created_at']));
            }

            array_push($newSamplings, array(
                'sensor_id' => $sensor_for_gsId[$sampling['generic_sensor_id']],
                'sampled' => $sampling['value'],
                'created_at' => $created_at
            ));
        }

        $successfully_inserted = DB::table('samplings')->insert($newSamplings);
        return $successfully_inserted ? 'Created ' . count($newSamplings) . ' sampling(s)' : 'Error during inserting';
    }

    /**
     * Display the specified resource.
     *
     * @param  int $productId
     * @param Requests\ShowingSamplingsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function show($productId, ShowingSamplingsRequest $request)
    {
        Product::findOrFail($productId); // Just to throw a failure if the product is not found
        $samplingsQueryBuilder = Sampling::query();

        $samplingsQueryBuilder->join('sensors', 'samplings.sensor_id', '=', 'sensors.id');
        $samplingsQueryBuilder->join('generic_sensors', 'sensors.generic_sensor_id', '=', 'generic_sensors.id');
        $samplingsQueryBuilder->join('products', 'sensors.product_id', '=', 'products.id');
        $samplingsQueryBuilder->where('products.id', $productId);

        $limit = $request->has('limit') && $request->limit < 1000 ? $request->limit : 1000;

        $timeFiltersApplied = $this->filterResultsInTime($samplingsQueryBuilder, $request);


        if ( ! $timeFiltersApplied)
        {
            $samplingsQueryBuilder->whereDate('samplings.created_at', '=', Carbon::today()->toDateString());
        }

        if ($request->generic_sensor_id)
        {
            $samplingsQueryBuilder->where('generic_sensors.id', $request->generic_sensor_id);
        }

        $samplingsQueryBuilder->orderBy('samplings.created_at', 'desc');
        $samplingsQueryBuilder->take($limit);

        return $samplingsQueryBuilder->get(
            array(
                'samplings.id',
                'samplings.sensor_id',
                'generic_sensors.id as generic_sensor_id',
                'samplings.sampled',
                'samplings.created_at'
            )
        );
    }

    private function filterResultsInTime(Builder &$samplingsQueryBuilder, $request)
    {
        if ($request->date)
        {
            $samplingsQueryBuilder->whereDate('samplings.created_at', '=', $request->date);
            return true;
        }

        if ($request->exists("today"))
        {
            $samplingsQueryBuilder->whereDate('samplings.created_at', '=', Carbon::today()->toDateString());
            return true;
        }

        if ($request->exists("yesterday"))
        {
            $samplingsQueryBuilder->whereDate('samplings.created_at', '=', Carbon::today()->subDay()->toDateString());
            return true;
        }

        if ($request->start)
        {
            $samplingsQueryBuilder->whereDate('samplings.created_at', '>=', $request->start);

            if ($request->end)
            {
                $samplingsQueryBuilder->whereDate('samplings.created_at', '<=', $request->end);
            }

            return true;
        }

        return false;
    }
}
