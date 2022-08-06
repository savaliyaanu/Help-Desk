<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorewellTesting extends Model
{
    protected $table='borewell_testing';
    protected $primaryKey='borewell_testing_id';
    protected $fillable=['challan_testing_id','branch_id','financial_id','voltage1','voltage2','voltage3','nl_amp1','nl_amp2','nl_amp3','max_amp1','max_amp2','max_amp3',
        'hz1','hz2','hz3','pf1','pf2','kw1','kw2','kw3','dp_amp1','dp_amp2','dp_amp3','so_head1','so_head2','so_head3','dp_head1','dp_head2',
        'dp_head3','disch1','disch2','disch3','remark','created_id','updated_id'];
}
