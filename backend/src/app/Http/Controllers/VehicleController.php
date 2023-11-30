<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Vehicle::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request)
    {
        $data = $request->only(['vehicle_type_id', 'license_plate_no']);
        extract($data);

        $entity = new Vehicle;
        $entity->vehicle_type_id = $vehicle_type_id;
        $entity->license_plate_no = $license_plate_no;
        $entity->save();

        return $entity;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return Vehicle::with('VehicleType')->with('VehicleLogs')->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('q');   
        return Vehicle::with('VehicleType')
            ->with('VehicleLogs')
            ->where('license_plate_no', 'like', "%$query%")
            ->whereHas('VehicleType', function($query) { $query->where('charge_type', 3); })
            ->get();
    }
}
