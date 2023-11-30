<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleTypes extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'cost_per_minute', 'charge_type'];

    public function Vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}
