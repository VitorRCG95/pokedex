<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemon';
    protected $fillable = array(
        'name', 
        'height',
        'weight',
        'type1',
        'type2',
        'image');
}
