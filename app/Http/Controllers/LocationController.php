<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(Location::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Location $location)
    {
        $request->validate([
            'postcode' => 'required',
            'locationable_id' => 'required',
            'locationable_type' => 'required'
        ]);

        $loc = $location->longlat($request->postcode);

        return response()->json(
            Location::create([
                'longitude' => $loc->get('longitude'),
                'latitude' => $loc->get('latitude'),
                'locationable_id' => $request->locationable_id,
                'locationable_type' => $request->locationable_type,
            ])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $Location
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(
            Location::findOrFail($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'longitude' => 'required',
            'latitude' => 'required',
            'locationable_id' => 'required',
            'locationable_type' => 'required'
        ]);

        return response()->json(
            Location::find($id)
                ->update($attributes)
        );
    }
}
