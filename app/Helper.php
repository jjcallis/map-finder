<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Location;
use Illuminate\Http\Request;

class Helper extends Model
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
