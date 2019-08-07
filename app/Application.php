<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Application extends Eloquent
{
    protected $connecttion = 'mongodb';

    protected $fillable = [
        'user_id', 'job_id',
    ];
}
