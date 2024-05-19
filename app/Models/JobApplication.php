<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory; 

    public function job(){
        return $this->belongsTo(Job::class);
    }

    public function jobHolderUser()
    {
        return $this->belongsTo(User::class, 'job_holder_id', 'id');
    }

    public function jobHolderAdmin()
    {
        return $this->belongsTo(Admin::class, 'job_holder_id', 'id');
    }

    public function done($id){
        return $this->where('job_id',$id)->where('status',2)->count();
    }
}
