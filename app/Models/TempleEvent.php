<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleEvent extends Model
{
    //
    protected $fillable = ['name', 'date', 'description', 'temple_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function temple()
    {
        return $this->belongsTo(Temple::class);
    }
}
