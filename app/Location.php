<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    protected $guarded = [];
    
    /**
     * Get the owning locationable model.
     */
    public function locationable()
    {
        return $this->morphTo();
    }

    /**
     * Add a location 
     * 
     * @param  string $postcode
     * @return \Illuminate\Http\Response
     */
    public function longlat($postcode) {
        $lat = 0.00000000;
        $long = 0.00000000;

        if ($postcode) {
            // url encode the postcode
            $postcode = urlencode($postcode);

            // google map geocode api url
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$postcode}&key=AIzaSyAdndxqZ2IuyQJrmwNGXe9xOA3B21hf-_U";

            // get the json response
            $resp_json = file_get_contents($url);

            // decode the json
            $resp = json_decode($resp_json, true);
            if ($resp['status'] == 'OK') {
                $geoResult = $resp;
            }

            $lat = !empty($geoResult) ? $geoResult['results'][0]['geometry']['location']['lng'] : 0.00000000;
            $long = !empty($geoResult) ? $geoResult['results'][0]['geometry']['location']['lat'] : 0.00000000;
        }

        return collect([
            'longitude' => $lat,
            'latitude' => $long,
        ]);
    }
}
