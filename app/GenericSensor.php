<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GenericSensor
 *
 * @property integer $id
 * @property string $alias
 * @property string $name
 * @property string $symbol
 * @property string $unit
 * @property string $range
 * @property string $producer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class GenericSensor extends Model
{
    protected $fillable = ['name', 'alias', 'unit'];

    public function sensors()
    {
        return $this->hasMany("App\Sensor");
    }
}
