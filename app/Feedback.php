<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public $timestamps = false;

    protected $table = 'feedbacks';

    protected $fillable = [
        'lon', 'lat', 'feedback_category_id', 'picture_url', 'userid'
    ];
}
