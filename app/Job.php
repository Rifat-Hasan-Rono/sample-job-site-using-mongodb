<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\User;

class Job extends Eloquent
{
    protected $connecttion = 'mongodb';

    protected $fillable = [
        'title', 'description', 'salary', 'location', 'country', 'user_id'
    ];

    public function applications()
    {
        return $this->hasMany('App\Application');
    }
}
