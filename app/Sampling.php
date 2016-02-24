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
    const UPDATED_AT = "created_at"; // we are never using the update method. so should be a good workaround

    protected $fillable = ['sensor_id', 'sampled', 'created_at'];

    public function sensor() {
        return $this->belongsTo('App\Sensor');
    }
}
