<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplacementExpense extends Model
{
    protected $table = 'replacement_expense';
    protected $primaryKey = 'expense_id';
    protected $fillable = ['city_name', 'state_id', 'mechanic_id', 'mechanic_id2', 'traveling_to', 'traveling_from', 'ta_da_amount', 'advance_amount', 'traveling_reason',
        'traveling_days', 'amount_taken_from_dealer', 'expense_amount', 'party_name', 'created_id', 'updated_id', 'company_id', 'financial_id','status','reason_for_callback','remark','complain_id'];

    public function getState()
    {
        return $this->belongsTo('App\States', 'state_id', 'state_id');
    }

    public function getMechanic()
    {
        return $this->belongsTo('App\Mechanic', 'mechanic_id', 'mechanic_id');
    }

}
