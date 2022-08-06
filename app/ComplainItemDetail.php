<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainItemDetail extends Model
{
    protected $table = 'complain_item_details';
    protected $primaryKey = 'cid_id';
    protected $fillable=['category_id','product_id','serial_no','complain','application','warranty','solution','solution_by','created_id','complain_status','created_at','updated_at','is_delete','production_no','invoice_no','invoice_date','is_used'];
}
