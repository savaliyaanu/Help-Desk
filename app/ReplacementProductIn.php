<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplacementProductIn extends Model
{
    protected $table = 'replacement_product_in';
    protected $primaryKey = 'replacement_product_id';
    protected $fillable = ['replacement_in_id', 'product_id', 'qty', 'image_name', 'created_id', 'updated_id', 'branch_id', 'financial_id','spare_id'];

    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'product_id', 'product_id');
    }

    public function getInProduct()
    {
        return $this->belongsTo('App\AdvanceReplacementIn', 'replacement_in_id', 'replacement_in_id');
    }
}
