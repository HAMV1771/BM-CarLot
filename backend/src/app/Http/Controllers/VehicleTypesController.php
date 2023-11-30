<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleTypesRequest;
use App\Http\Requests\UpdateVehicleTypesRequest;
use App\Models\VehicleTypes;

class VehicleTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return VehicleTypes::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleTypesRequest $request)
    {
        $data = $request->only(['description', 'cost_per_minute', 'charge_type']);
        extract($data);

        $entity = new VehicleTypes;
        $entity->description = $description;
        $entity->cost_per_minute = $cost_per_minute;
        $entity->charge_type = $charge_type;
        $entity->save();

        return $entity;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return VehicleTypes::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleTypesRequest $request, VehicleTypes $vehicleTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleTypes $vehicleTypes)
    {
        //
    }
}
