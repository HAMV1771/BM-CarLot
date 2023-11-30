<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    public function VehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleTypes::class);
    }

    public function VehicleLogs(): HasMany
    {
        return $this->hasMany(VehicleLog::class);
    }
}
