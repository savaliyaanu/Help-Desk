<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplacementExpenseProductIn extends Model
{
    protected $table = 'replacement_expense_product_in';
    protected $primaryKey = 'expense_product_in_id';
    protected $fillable = ['expense_id', 'category_id', 'spare_id',  'qty',  'financial_id', 'created_id', 'updated_id', 'branch_id'];

    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'product_id', 'product_id');
    }
}
