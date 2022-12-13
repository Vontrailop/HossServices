<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [ 'id', 'status', 'date_and_hour', 'room_id', 'user_id'];

    public $timestamps = false;


    public function room(){
        //Belongs to siempre lo lleva el hijo y puede ser de uno a uno o a muchos
        //El hijo es la tabla que tiene el campo que tiene referencia al papá
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function user(){
        //Belongs to siempre lo lleva el hijo y puede ser de uno a uno o a muchos
        //El hijo es la tabla que tiene el campo que tiene referencia al papá
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
