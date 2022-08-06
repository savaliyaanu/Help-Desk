<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMaster extends Model
{
    protected $table='company_master';
    protected $primaryKey='company_id';
    protected $fillable=['company_name','address1','address2','address3','city_id','district_id','state_id','phone','pincode','email','created_id','updated_id'];

    public function getCity(){
        return $this->belongsTo('App\Citys','city_id','city_id');
    }
    public function getDistrict(){
        return $this->belongsTo('App\Districts','district_id','district_id');
   }
    public function getState(){
        return $this->belongsTo('App\States','state_id','state_id');
    }
    public function getGodownDetail(){
        return $this->belongsTo('App\GodownMaster','company_id','company_id');
    }

}
