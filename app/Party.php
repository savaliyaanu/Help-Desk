<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $table = 'replacement_expense_item';
    protected $primaryKey = 'expense_item_id';
    protected $fillable = ['expense_id', 'product_id', 'qty', 'branch_id', 'company_id', 'created_id', 'updated_id', 'financial_id', 'party_name', 'city_name', 'address', 'mobile_no', 'sr_no'];
}
