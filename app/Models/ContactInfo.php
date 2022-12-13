<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = "contact_info";

    protected $fillable = ['id', 'street', 'number', 'colony', 'city'];

    public $timestamps = false;

    public function person()
    {
        return $this->hasOne(Person::class);
    }

}
