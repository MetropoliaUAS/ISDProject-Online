<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSamplingsRequest;
use App\Http\Requests\ShowingSamplingsRequest;
use App\Product;
use App\Sampling;
use App\Sensor;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Builder;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SamplingsController extends Controller
{

    private $guard;

    /**
     * SamplingsController constructor.
     * @param $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

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
            Sensor::join('products', 'sensors.product_id', '=', 'products.id')
                ->whereIn('sensors.generic_sensor_id', $samplings_groupBy_gsIds->keys())
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

            if ( ! array_has($sensor_for_gsId, $sampling['generic_sensor_id']) ) continue;
            array_push($newSamplings, array(
                'sensor_id' => $sensor_for_gsId[$sampling['generic_sensor_id']],
                'sampled' => $sampling['value'],
                'created_at' => $created_at
            ));
        }

        DB::table('samplings')->insert($newSamplings);
        return 'Created ' . count($newSamplings) . ' sampling(s)';
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
        $product = Product
            ::join('locations', 'locations.product_id', '=', 'products.id')
            ->where('locations.user_id', $this->guard->user()->getKey())
            ->findOrFail($productId); // Just to throw a failure if the product is not found
        $samplingsQueryBuilder = Sampling::query();

        $samplingsQueryBuilder->join('sensors', 'samplings.sensor_id', '=', 'sensors.id');
        $samplingsQueryBuilder->join('generic_sensors', 'sensors.generic_sensor_id', '=', 'generic_sensors.id');
        $samplingsQueryBuilder->join('products', 'sensors.product_id', '=', 'products.id');
        $samplingsQueryBuilder->where('products.id', $productId);

        $samplingsQueryBuilder->orderBy('samplings.created_at', 'desc');

        $limit = $request->has('limit') && $request->limit < 1000 ? $request->limit : 1000;

        if ($request->generic_sensor_id)
        {
            $samplingsQueryBuilder->where('generic_sensors.id', $request->generic_sensor_id);
        }

        $timeFiltersApplied = $this->filterResultsInTime($samplingsQueryBuilder, $request, $product);

        if ( ! $timeFiltersApplied)
        {
            $samplingsQueryBuilder->whereDate('samplings.created_at', '=', Carbon::today()->toDateString());
        }

        $samplingsQueryBuilder->take($limit);

//        if ($timeFiltersApplied && array_has(["week", "month", "year"], $request->timeFilter)) {
//            return $samplingsQueryBuilder->selectRaw("
//                samplings.sensor_id,
//                max(samplings.sampled),
//                generic_sensors.id as generic_sensor_id,
//                min(samplings.created_at)
//            ");
//        }

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

    private function filterResultsInTime(Builder &$samplingsQueryBuilder, $request, Product $product)
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

        if ($request->timeFilter)
        {
            $secondQueryBuilder = clone $samplingsQueryBuilder;
            $lastSampling =
                $secondQueryBuilder->take(1)->get(["samplings.created_at"])->first()
                    ->created_at->copy();

            switch ($request->timeFilter) {
                case "hour":
                    $lastHour = $lastSampling->subHour()->toDateTimeString();
                    $samplingsQueryBuilder->where("samplings.created_at", ">", $lastHour);
                    break;

                case "today":
                    $today = $lastSampling->toDateString();
                    $samplingsQueryBuilder->whereDate("samplings.created_at", "=", $today);
                    break;

                case "yesterday":
                    $lastDay = $lastSampling->subDay()->toDateString();
                    $samplingsQueryBuilder->whereDate("samplings.created_at", "=", $lastDay);
                    break;

                case "week":
                    $lastWeek = $lastSampling->subWeek()->toDateTimeString();
                    $samplingsQueryBuilder->where("samplings.created_at", ">", $lastWeek);
                    break;

                case "month":
                    $lastMonth = $lastSampling->subMonth()->toDateTimeString();
                    $samplingsQueryBuilder->where("samplings.created_at", ">", $lastMonth);
                    break;

                case "year":
                    $lastYear = $lastSampling->subYear()->toDateTimeString();
                    $samplingsQueryBuilder->where("samplings.created_at", ">", $lastYear);
                    break;
            }

            return true;
        }

        return false;
    }
}
