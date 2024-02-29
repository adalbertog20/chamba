<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['street', 'postal_code', 'number', 'city'];
    protected $hidden = [];

    protected $casts = [];
}
