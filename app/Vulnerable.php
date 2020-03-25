<?php

namespace App;

use App\Location;
use Illuminate\Database\Eloquent\Model;

class Vulnerable extends Model
{

    protected $guarded = [];

   /**
     * Get the location
     */
    public function location()
    {
        return $this->morphOne(Location::class, 'locationable');
    }
}
