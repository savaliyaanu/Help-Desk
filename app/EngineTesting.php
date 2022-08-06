<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EngineTesting extends Model
{
    protected $table = 'engine_testing';
    protected $primaryKey = 'testing_id';
    protected $fillable = ['challan_testing_id', 'checking_date', 'reading', 'sfc', 'temp_rpm', 'temp_percentage', 'perm_rpm', 'perm_percentage', 'testing_by'];

    public function getTestingMaster()
    {
        return $this->belongsTo('App\ChallanTestingMaster', 'challan_testing_id', 'challan_testing_id');

    }
}
