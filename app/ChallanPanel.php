<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallanPanel extends Model
{
    protected $table = 'challan_panel';
    protected $primaryKey = 'challan_panel_id';
    protected $fillable = ['challan_id', 'panel_id', 'panel_qty', 'created_id'];

    public function getProduct()
    {
        return $this->belongsTo('App\Products', 'panel_id', 'product_id');
    }
}
