<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'origin',
        'destination',
        'start_date',
        'end_date',
        'type_of_trip',
        'description',
    ];
}
