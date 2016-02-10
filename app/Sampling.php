<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Sampling
 *
 * @property integer $id
 * @property integer $sensor_id
 * @property integer $sampled
 * @property \Carbon\Carbon $created_at
 */
class Sampling extends Model
{
    protected $fillable = ['sensor_id', 'sampled', 'created_at'];

    public function sensor() {
        return $this->belongsTo('App\Sensor');
    }
}
