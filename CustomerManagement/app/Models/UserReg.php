<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReg extends Model
{
    protected $table='userg';
    protected $fillable=['name','phone','bdate','email'];
    //
}
