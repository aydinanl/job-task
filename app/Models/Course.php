<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course';

    public $timestamps = false;
    protected $dates = ['created_at','updated_at'];

    protected $fillable = [
        'id', 'course_name', 'university'
    ];

    public function students()
    {
        return $this->hasMany('App\Models\Students');
    }
}
