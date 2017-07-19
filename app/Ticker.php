<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ticker extends Model
{
    public function create($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = time();
        }
        return DB::table('ticker')->insertGetId($data);
    }
}
