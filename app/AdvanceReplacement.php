<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvanceReplacement extends Model
{
    protected $table = 'advance_replacement_out';
    protected $primaryKey = 'replacement_out_id';
    protected $fillable = ['complain_id', 'product_id', 'branch_id', 'financial_id', 'financial_year', 'billty_no', 'company_name', 'order_id', 'transport_id', 'lr_no', 'lory_no', 'mobile_no', 'status', 'created_id', 'updated_id'];

    public function getComplain()
    {
        return $this->belongsTo('App\Complain', 'complain_id', 'complain_id');
    }

    public function getTransport()
    {
        return $this->belongsTo('App\Transport', 'transport_id', 'transport_id');
    }

    public function getOrder()
    {
        return $this->belongsTo('App\OrderMaster', 'order_id', 'order_id');
    }
}
