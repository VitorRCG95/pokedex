<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = 'auth';
    protected $fillable = array('user', 'password', 'token', 'validate_token');
}
