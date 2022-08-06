<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table='branch_master';
    protected $primaryKey='branch_id';
    protected $fillable=['company_id','address1','address2','address3','city_id','district_id','state_id','pincode','gst_no','created_id','updated_id','branch_ic'];

    public function getCompany(){
        return $this->belongsTo('App\CompanyMaster','company_id','company_id');
    }
    public function getCity(){
        return $this->belongsTo('App\Citys','city_id','city_id');
    }
}
