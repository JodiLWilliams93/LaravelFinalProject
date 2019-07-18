<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Climb extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rating', 'description', 'type', 'location', 'added_by', 'gear_needed', 'length'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
