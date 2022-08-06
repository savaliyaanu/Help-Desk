<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectionReport extends Model
{
    protected $table = 'inspection_report';
    protected $primaryKey = 'inspection_report_id';
    protected $fillable = ['challan_id', 'challan_product_id', 'branch_id', 'mechanic_name', 'crank_shaft1', 'crank_shaft2', 'crank_shaft3', 'crank_shaft4', 'trb_bb1', 'trb_bb2', 'trb_bb3', 'cr_bearing1',
        'cr_bearing2', 'cyl_liner1', 'cyl_liner2', 'piston1', 'piston2', 'piston3', 'gudgeon_pin1', 'gudgeon_pin2', 'gudgeon_pin3', 'gudgeon_pin4', 'ring_set1', 'ring_set2', 'ring_set3',
        'con_rod1', 'con_rod2', 'con_rod3', 'con_rod4', 'cam_shaft1', 'cam_shaft2', 'cam_shaft3', 'cam_shaft4', 'valve1', 'valve2', 'valve3', 'valve4', 'ram_roller1', 'ram_roller2',
        'ram_roller3', 'ram_roller4', 'cyl_head1', 'cyl_head2', 'cyl_hea3', 'valve_guide1', 'valve_guide2', 'side_cover1', 'side_cover2', 'side_cover3', 'crank_case1', 'crank_case2',
        'crank_case3', 'crank_cas4', 'componentsA1', 'componentsA2', 'componentsA3', 'componentsA4', 'componentsB1', 'componentsB2', 'components3', 'componentsB4','problem',
        'componentsC1', 'componentsC2', 'componentsC3', 'componentsC3', 'componentsD1', 'componentsD2', 'componentsD3', 'componentsD4', 'company_observation', 'checked_by', 'fault',
        'financial_id', 'created_id', 'updated_id', 'parts_replaced', 'external', 'internal', 'component_changed_fitted', 'complain', 'observation', 'change','product_id'];

    public function getChallanProduct()
    {
        return $this->belongsTo('App\ChallanProduct', 'challan_product_id', 'challan_product_id');
    }
}
