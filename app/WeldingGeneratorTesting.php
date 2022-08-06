<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeldingGeneratorTesting extends Model
{
    protected $table = 'welding_generator_testing';
    protected $primaryKey = 'welding_generator_testing_id';
    protected $fillable = ['challan_testing_id', 'branch_id', 'voltage_low', 'voltage_high', 'voltage_lighting', 'temperature', 'no_load1', 'no_load2', 'no_load3', 'no_load4', 'no_load5', 'no_load6', 'no_load7',
        'resistive_load1', 'resistive_load2', 'resistive_load3', 'resistive_load4', 'resistive_load5', 'resistive_load6', 'resistive_load7' .
        'welding_low1', 'welding_low2', 'welding_low3', 'welding_low4', 'welding_low5', 'welding_low6', 'welding_low7',
        'welding_high1','welding_high2','welding_high3','welding_high4','welding_high5','welding_high6','welding_high7','created_id','updated_id','financial_id'];
}
