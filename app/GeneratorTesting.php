<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneratorTesting extends Model
{
    protected $table = 'generator_testing';
    protected $primaryKey = 'generator_testing_id';
    protected $fillable = ['challan_testing_id', 'branch_id', 'ac_voltage', 'watts', 'dc_voltage_nl', 'dc_voltage_fl', 'dc_amp_nl', 'dc_amp_fl',
        'rpm_nl', 'rpm_fl', 'ac_voltage_ifl', 'ac_voltage_pf', 'ac_voltage_rfl', 'ac_voltage_pfl', 'ac_amp_ol', 'ac_amp_pfl', 'watts_rfl',
        'vr_ifl', 'rfl', 'kbl', 'amount_temp', 'regi', 'stator_main_winding', 'stator_aux_winding', 'ex_fld_wnd_regi', 'ex_arm_wnd_regi',
        'created_id', 'updated_id'];
}
