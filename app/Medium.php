<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medium extends Model
{
    protected $table = 'medium';
    protected $primaryKey = 'medium_id';
    protected $fillable =['medium_name'];
}
