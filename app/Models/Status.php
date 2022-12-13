<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    protected $fillable = ['id', 'description'];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function room()
    {
        return $this->hasOne(Room::class);
    }

}
