<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable =['name','file_path','status','user_id'];

    protected $hidden =['updated_at' ,'pivot'];


    public function user(){

    return $this->belongsTo('App/user','user_id');

    }
    public function reserved(){
        return $this->hasOne('App\Models\ReservedFile','file_id')->where('status',0);

    }


}
