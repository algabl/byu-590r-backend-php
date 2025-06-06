<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Temple extends Model
{
    protected $fillable = ['name', 'latitude', 'longitude', 'status', 'walk_score', 'bike_score', 'transit_score', 'temple_image'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'walk_score' => 'integer',
            'bike_score' => 'integer',
            'transit_score' => 'integer',
        ];
    }

    public function templeDetails()
    {
        return $this->hasOne(TempleDetails::class);
    }
    public function templeEvents()
    {
        return $this->hasMany(TempleEvent::class);
    }

    public function transitStops():BelongsToMany
    {
        return $this->belongsToMany(TransitStop::class);
    }
}