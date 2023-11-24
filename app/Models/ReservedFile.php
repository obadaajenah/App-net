<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedFile extends Model
{
    use HasFactory;

    protected $fillable =['user_id','file_id' ,'status' ,'type'];

    protected $hidden =['status','file_id','user_id','updated_at'];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function file(){
        return $this->belongsTo('App\Models\File','file_id');
    }



}
