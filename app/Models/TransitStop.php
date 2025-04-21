<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TransitStop extends Model
{
    //
    protected $fillable = ['name', 'latitude', 'longitude', 'type', 'frequency'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'frequency' => 'integer',
        ];
    }
    // many to many relationship with temple
    public function temples(): BelongsToMany
    {
        return $this->belongsToMany(Temple::class);
    }
}
