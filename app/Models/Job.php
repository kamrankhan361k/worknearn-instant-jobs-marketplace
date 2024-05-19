<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $with = ['jobApplications'];

    public function scopeApproved()
    {
        return $this->where('status', '=', 1);
    }

    public function scopePending()
    {
        return $this->where('status', '=', 0);
    }

    public function scopeHolding()
    {
        return $this->where('job_status', '=', 0);
    }

    public function scopeActive()
    {
        return $this->where('job_status', '=', 1);
    }

    public function scopeFinished()
    {
        return $this->where('job_status', '=', 2);
    }

    public function scopeUserJobs()
    {
        return $this->where('owner_type', '=', 2);
    }
    public function scopeAdminJobs()
    {
        return $this->where('owner_type', '=', 1);
    }

    public function scopeMyJobs()
    {
        return $this->where('owner_type', '=', 1)->where('owner_id', auth('admin')->id());
    }

    public function ownerUser()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function ownerAdmin()
    {
        return $this->belongsTo(Admin::class, 'owner_id', 'id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'job_id', 'id');
    }

    public function done(){
        return $this->jobApplications->where('status',2)->count();
    }
    
    public function read_status(){
        return $this->jobApplications->where('read_status',0)->count();
    }

}
