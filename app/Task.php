<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model
{
    //protected $guarded = []; //Signigie que tous les champs sont $fillable. Dans notre cas seul le body est $fillable
    protected $fillable = [
        'body',
        'order',
        'user_id'
    ];

}