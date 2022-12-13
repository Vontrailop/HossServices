<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = "people";

    protected $fillable = ['id', 'name', 'surname', 'second_surname', 'contact_info'];

    protected $hidden = ['contact_info_id'];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function contactInfo()
    {
        return $this->belongsTo(ContactInfo::class);
    }

}
