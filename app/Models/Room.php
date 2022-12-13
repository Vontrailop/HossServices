<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [ 'id', 'building_id', 'status_id', 'floor', 'number'];

    public $timestamps = false;

    public function category(){
        //Belongs to siempre lo lleva el hijo y puede ser de uno a uno o a muchos
        //El hijo es la tabla que tiene el campo que tiene referencia al papá
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

}
