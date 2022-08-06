<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billty extends Model
{
    protected $table = 'billty';
    protected $primaryKey = 'billty_id';
    protected $fillable = ['client_id', 'branch_id', 'company_id', 'complain_id', 'freight_rs_by', 'challan_type', 'other', 'dealer_name', 'billty_no', 'gst_no', 'entry_date', 'transport_id', 'freight_rs', 'lr_no', 'lr_date', 'entry_by', 'remark', 'created_id', 'updated_id'];

    public function getClients()
    {
        return $this->belongsTo('App\Clients', 'client_id', 'client_id');
    }

    public function getComplain()
    {
        return $this->belongsTo('App\Complain', 'complain_id', 'complain_id');
    }

    public function getCity()
    {
        return $this->belongsTo('App\Citys', 'city_id', 'city_id');
    }

    public function getTransport()
    {
        return $this->belongsTo('App\Transport', 'transport_id', 'transport_id');
    }
    public function getUserName()
    {
        return $this->belongsTo('App\User', 'created_id', 'user_id');
    }

}
