<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class calenderModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_case';
    public static function getRecord()
    {
        return DB::table('tbl_case');
    }
}
