<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleLog extends Model
{
    use HasFactory;

    public function Vehicle(): BelongsTo
    {
        return $this->BelongsTo(Vehicle::class);
    }

    public function User(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
