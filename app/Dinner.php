<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Dinner extends Model
{
    protected $table = 'dinner';

    public function create($data){
        $keys = implode(',', array_keys($data));
        $val  = array_values($data);

            //$res = DB::insert('insert into d_dinner (' . $keys . ') values (?, ?, ?, ?, ?)', $val);
        $res = DB::insert('insert into d_dinner (' . $keys . ') values (?, ?, ?, ?, ?)
              on duplicate key update updated_at=\'' . date('Y-m-d H:i:s') . '\'', $val);


        if($res){
            return $res;
        }else{
            return false;
        }
    }
}
