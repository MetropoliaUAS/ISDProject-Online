<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Sensor
 *
 * @property integer $id
 * @property integer $generic_sensor_id
 * @property string $product_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Sensor extends Model
{
    protected $fillable = ['generic_sensor_id'];

    public function genericSensor(){
        return $this->belongsTo("App\GenericSensor", "generic_sensor_id");
    }

    public function samplings() {
        return $this->hasMany("App\Sampling");
    }
}
