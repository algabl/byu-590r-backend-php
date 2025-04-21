<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleDetails extends Model
{
    //
    use HasFactory;
    protected $fillable = ['temple_id', 'architect', 'square_footage', 'number_ordinance_rooms', 'number_sealing_rooms', 'number_surface_parking_spots', 'additional_notes'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function temple()
    {
        return $this->belongsTo(Temple::class);
    }
}
