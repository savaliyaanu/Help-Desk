<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvanceReplacementIn extends Model
{
    protected $table = 'advance_replacement_in';
    protected $primaryKey = 'replacement_in_id';
    protected $fillable = ['replacement_out_id', 'branch_id', 'financial_id', 'bill_no', 'billty_no', 'inward_date', 'transport_id', 'created_id', 'updated_id'];

    public function getProductOut()
    {
        return $this->belongsTo('App\AdvanceReplacement', 'replacement_out_id', 'replacement_out_id');
    }

    public function getTransport()
    {
        return $this->belongsTo('App\Transport', 'transport_id', 'transport_id');
    }
}
