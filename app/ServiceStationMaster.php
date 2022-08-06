<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceStationMaster extends Model
{
    protected $table='service_station_master';
    protected $primaryKey = 'station_id';
    protected $fillable =['station_name','station_address','contact_no','email','contact_person_name'];
}
