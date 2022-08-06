<?php

namespace App;

use App\Events\AssignComplainEvent;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table = 'complain';
    protected $primaryKey = 'complain_id';
    protected $fillable = ['client_id', 'branch_id', 'company_id', 'complain_status', 'created_id', 'updated_id', 'client_name',
        'address', 'mobile', 'city_id', 'district', 'state', 'medium_id', 'assign_id', 'problem', 'solution_by', 'complain_type', 'resolve_date'];

    public function getCity()
    {
        return $this->belongsTo('App\Citys', 'city_id', 'city_id');
    }

    public function getClients()
    {
        return $this->belongsTo('App\Clients', 'client_id', 'client_id');
    }

    public function getMediumDetails()
    {
        return $this->belongsTo('App\Medium', 'medium_id', 'medium_id');
    }

    protected $dispatchesEvents = [
        'created' => AssignComplainEvent::class,
    ];
}
