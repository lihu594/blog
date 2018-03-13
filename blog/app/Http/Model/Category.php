<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];

    public function getTree($data)
    {
        $arr = array();
        $arr1 = array();
        foreach ($data as $k=>$v){
            if($v->cate_pid==0){
                $data[$k]['_cate_name'] = $data[$k]['cate_name'];
                $arr[] = $data[$k];
            }
            foreach ($data as $m=>$n) {
                if($n->cate_pid == $v->cate_id){
                    $data[$m]['_cate_name'] = '|— '.$data[$m]['cate_name'];
                    $arr[] = $data[$m];
                }
            }
        }
        return $arr;
    }

}
