<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property string $id
 * @property string $version
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Product extends Model
{
    public $incrementing = false;

    protected $fillable = ['id', 'version'];

    public function sensors()
    {
        return $this->hasMany('App\Sensor');
    }
}
