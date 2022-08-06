<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherExpense extends Model
{
    protected $table='replacement_other_expense';
    protected $primaryKey='other_expense_id';
    protected $fillable=['detail','amount','is_delete','company_id','financial_id','created_id','updated_id'];
}
