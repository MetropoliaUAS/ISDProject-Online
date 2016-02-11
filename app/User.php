<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\User
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function location () {
        return $this->hasOne("App\Location");
    }

    /**
     * @return Builder
     */
    public function sensors () {
        return Sensor
            ::join('products', 'sensors.product_id', '=', 'products.id')
            ->join('locations', 'locations.product_id', '=', 'products.id')
            ->where('locations.user_id', $this->getKey());
    }

    public function products () {
        return Product
            ::join('locations', 'locations.product_id', '=', 'products.id')
            ->where('locations.user_id', $this->getKey());
    }
}
