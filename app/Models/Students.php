<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student';

    public $timestamps = false;
    protected $dates = ['created_at','updated_at'];

    protected $fillable = [
        'id', 'firstname', 'surname', 'email', 'nationality', 'address_id', 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function address()
    {

        return $this->hasOne('App\Models\StudentAddresses', 'id','address_id');
    }
}
