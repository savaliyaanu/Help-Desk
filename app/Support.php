<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support';
    protected $primaryKey = 'faq_id';
    protected $fillable = ['questions', 'category_id', 'created_id', 'updated_id', 'branch_id'];

    public function getCategory()
    {
        return $this->belongsTo('App\Category', 'category_id', 'category_id');
    }

    public function getCase()
    {
        return $this->hasMany('App\CaseSolution', 'faq_id', 'faq_id')->groupBy('case')->groupBy('faq_id');
    }
}
