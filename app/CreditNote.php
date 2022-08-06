<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    protected $table = 'credit_note';
    protected $primaryKey = 'credit_note_id';
    protected $fillable = ['challan_id', 'remark', 'created_id', 'branch_id', 'updated_id', 'financial_id', 'credit_note_no', 'company_id'];

    public function getChallan()
    {
        return $this->belongsTo('App\Challan', 'challan_id', 'challan_id');
    }

    public function getAmount()
    {
        return $this->belongsTo('App\CreditNoteItem', 'credit_note_id', 'credit_note_id');
    }
}
