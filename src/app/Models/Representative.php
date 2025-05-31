<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    protected $fillable = ['name'];

    public function cities()
    {
        return $this->belongsToMany(City::class);
    }
}
