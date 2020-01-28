<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Article extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';
    protected $fillable = [
        'title',
        'body',
        'tags',
        'created_by',
        'deleted_at',
    ];
}
