<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceStation extends Model
{
    protected $table='service_station';
    protected $primaryKey='service_id';
    protected $fillable=['company_id','branch_id','service_station_name','created_id','updated_id'];

    public function getBranchName(){
        return $this->belongsTo('App\Branch','branch_id','branch_id');
    }
    public function getCompany(){
        return $this->belongsTo('App\CompanyMaster','company_id','company_id');
    }
}
