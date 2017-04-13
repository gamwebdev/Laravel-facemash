<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
    'title',
    'filename',
    'country',
    'score',
    'wins',
    'losses',
    'rank'
    ];
}
