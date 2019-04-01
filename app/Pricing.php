<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pricings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['location_id','price','customer_id'];

    public function location()
    {
        return $this->belongsTo('App\StreetsNeighbourhoodAndCities', 'location_id');
    }

}
