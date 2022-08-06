<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelingExpense extends Model
{
    protected $table='replacement_traveling_expense';
    protected $primaryKey='traveling_expense_id';
    protected $fillable=['expense_id','travel_date','time_from','time_to','traveling_detail','place','hault','journey','amount','created_id','updated_id','company_id','financial_id','is_delete'];
}
