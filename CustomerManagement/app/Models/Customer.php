<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customers';
    public $timestamps=false;
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;
    protected $fillable=['user_id','name', 'question_number', 'question', 'response',];
   # protected $fillable=['username','question_number ','response',];
}
