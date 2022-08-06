<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseSolution extends Model
{
    protected $table = 'case_solution';
    protected $primaryKey='case_id';
    protected $fillable=['faq_id','case','solution'];


}
