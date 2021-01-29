<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;

    protected $fillable = ['block_list','type','user_id','building_id'];

    public function building(){
        return $this->hasOne(Building::class, 'id', 'building_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
