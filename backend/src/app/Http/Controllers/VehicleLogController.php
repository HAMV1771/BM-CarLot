<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleLogRequest;
use App\Http\Requests\UpdateVehicleLogRequest;
use App\Models\VehicleLog;
use Carbon\Carbon;
use Illuminate\Http\Response;

class VehicleLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return VehicleLog::with('Vehicle')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleLogRequest $request)
    {
        $data = $request->only(['vehicle_id']);
        extract($data);

        $entity = new VehicleLog;
        $entity->user_id = 1;
        $entity->vehicle_id = $vehicle_id;
        $entity->entryAt = Carbon::now()->toDateTimeString();
        $entity->charged = false;
        $entity->save();

        return $entity;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $type = $id;
        return VehicleLog::with('Vehicle')->whereHas('Vehicle', function($query) use ($type) { $query->where('vehicle_type_id', $type); })->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id)
    {
        $entity = VehicleLog::find($id)->orderBy('id', 'DESC')->limit(1)->first();

        if(!$entity) {
            return response()->json(['status' => 'error', 'message' => 'Invalid log ID'], 400);
        }

        if($entity->outAt != null) {
            return response()->json(['status' => 'error', 'message' => 'Vehicle already checked out.'], 400);
        }

        $entity->charged = true;
        $entity->outAt = Carbon::now()->toDateTimeString();
        $entity->save();

        return $entity;
    }

    public function startMonth() {
        // Delete entries for "Oficial" vehicle types.
        //VehicleLog::with('Vehicle')->whereHas('Vehicle.VehicleType', function($query) { $query->where('charge_type', 1); })->destroy();

        // Return entries that must be charged at the end of month and reset their time count
        $residentVehicles = VehicleLog::with('Vehicle.VehicleType')->whereHas('Vehicle.VehicleType', function($query) { $query->where('charge_type', 3); });

        $now = Carbon::now();

        $report = array_map(function($entry) use($now) {
            $entryIn = Carbon::parse($entry['entryAt']);
            $timeIn = $now->diffInMinutes($entryIn);

            return [
                "vehicle_id" => $entry['vehicle']['id'],
                "vehicle_plate" => $entry['vehicle']['license_plate_no'],
                "total_minutes" => $timeIn,
                "total_cost" => $timeIn * floatval($entry['vehicle']['vehicle_type']['cost_per_minute']),
                "entryAt" => $entry['entryAt'],
            ];
        }, $residentVehicles->get()->toArray());
        
        $residentVehicles->update(['entryAt' => $now->toDateTimeString()]);

        return [
            "end_date" => $now->toDateTimeString(),
            "vehicles" => $report,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleLog $vehicleLog)
    {
        //
    }

    public function visits() {
        $entries = VehicleLog::with('Vehicle.VehicleType')
            ->whereHas('Vehicle.VehicleType', function($query) { $query->where('charge_type', 3); })
            ->where('outAt', null)->get();

        return [
            "entries" => $entries,
            "server_date" => Carbon::now()->toDateTimeString(),
        ] ;
    }
}
