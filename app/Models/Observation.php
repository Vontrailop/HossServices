<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $table = "observations";

    protected $fillable = ['id',
                            'date',
                            'description',
                            'picture',
                            'rooms_id',
                            'users_id'
                        ];

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
