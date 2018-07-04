<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAddresses extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_address';

    public $timestamps = false;
    protected $dates = ['created_at','updated_at'];

    protected $fillable = [
        'id', 'houseNo', 'line_1', 'line_2', 'postcode', 'city'
    ];

    public function students()
    {
        return $this->hasMany('App\Models\Students');
    }
}
