<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Model;

class Post extends Model
{
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'short_description',
        'date',
        'tags',
        'slug'
    ];
}