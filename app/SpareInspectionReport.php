<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpareInspectionReport extends Model
{
    protected $table = 'spare_inspection_report';
    protected $primaryKey = 'spare_inspection_id';
    protected $fillable = ['challan_optional_id', 'challan_product_id', 'inspection_report_id', 'product_id', 'complain', 'observation', 'part_change', 'created_id',
        'updated_id', 'branch_id'];
}
