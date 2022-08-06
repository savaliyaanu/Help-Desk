<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    protected $table='financial_year';
    protected $primaryKey='financial_id';
    protected $fillable=['date_from','date_to','is_active','is_delete','is_data','action_caption','company_id','branch_id','fyear','year_heading','created_id','updated_id'];
}
