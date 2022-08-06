<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainMedium extends Model
{
    protected $table = 'complain_medium_details';
    protected $primaryKey = 'cmd_id';
    protected $fillable = ['complain_id', 'whatsapp_no', 'email', 'voucher_no', 'mobile_no', 'vehicle_no', 'staff_name',
        'created_id', 'updated_id', 'created_at', 'updated_at'];
}
