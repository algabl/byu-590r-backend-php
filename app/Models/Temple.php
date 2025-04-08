<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temple extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'latitude', 'longitude', 'status', 'walk_score', 'bike_score', 'transit_score', 'temple_image'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function templeDetails()
    {
        return $this->hasOne(TempleDetails::class);
    }
}