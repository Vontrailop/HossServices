<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamberMaidRoom extends Model
{
    use HasFactory;

    protected $table = "observations";

    protected $fillable = ['id', 'rooms_id', 'users_id'];
    
    public $timestamps = false;

    public function rooms()
    {
        return $this->belongsTo(Room::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
