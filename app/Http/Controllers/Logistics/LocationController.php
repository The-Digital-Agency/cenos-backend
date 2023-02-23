<?php

namespace App\Http\Controllers\Logistics;

use App\Zone;
use Validator;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $locations = Location::with('zone')->orderBy('delivery_location', 'ASC')->get();
        return  response()->json($locations, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'delivery_location' => 'required',
            'delivery_charge' => 'required'
        ]);
        $input = $request->all();
        $location = Location::create($input);
        return  response()->json($location, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $location = Location::findOrFail($id);
        return  response()->json($location, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $location = Location::findOrFail($request->id);

        $this->validate($request, [
            'delivery_location' => 'required',
            'delivery_charge' => 'required'
        ]);

        $input = $request->all();
        $location->update($input);

        return response()->json($location, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return response()->json(null, 204);
    }

    /**
     * Get all orders to a specific location
     *
     * @param $id
     * @return JsonResponse
     */
    public function orders($id)
    {
        $location = Location::findOrFail($id);

        return response()->json($location->orders, 200);
    }

    // Zones Workflow


    /**
     * Store Zone
     *
     * @param Request $request
     * @return void
     */
    public function storeZone(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
        ])->validate();

        $zone = Zone::create($request->all());

        return response()->json($zone, 200);
    }


    /**
     * Fetch All Zones
     *
     * @return void
     */
    public function getZones()
    {
        $zones = Zone::all();
        if ($zones->isEmpty()) {
            for ($i = 1; $i <= 13; $i++) {
                Zone::create([
                    'name' => 'Zone ' . $i
                ]);
            }

            $zones = Zone::all();
        }
        return response()->json($zones);
    }

    /**
     * Fetch All Zones
     *
     * @return void
     */
    public function getAllZones()
    {
        $zones = Zone::latest()->paginate(20);
        return response()->json($zones);
    }
}
