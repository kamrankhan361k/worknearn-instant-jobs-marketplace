<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Http\Controllers\Controller;

class JobApplicationController extends Controller
{
    public function appliedJob()
    {
        $pageTitle = 'My Submission Jobs';
        $jobApplications = JobApplication::with(['job', 'job.ownerUser', 'job.ownerAdmin'])
            ->selectRaw('DISTINCT job_id')
            ->where('job_holder_id', auth('admin')->id())
            ->where('job_holder_type', 1)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        return view('admin.job.applied_job', compact('pageTitle', 'jobApplications'));
    }

    public function jobProof($id)
    {
        $pageTitle = 'My Proof list';
        $jobApplications = JobApplication::with('job')->where('job_id', $id)->where('job_holder_id', auth('admin')->id())
            ->where('job_holder_type', 1)->paginate(getPaginate());
        return view('admin.job.job_proof', compact('pageTitle', 'jobApplications'));
    }

    public function jobAttachmentDownload($id)
    {
        $jobApplication = JobApplication::where('id', $id)->where('job_holder_id', auth('admin')->id())->where('job_holder_type', 1)->first();
        if ($jobApplication) {
            $file = $jobApplication->attachments;
            if ($file) {
                return response()->download($file);
            } else {
                $notify[] = ['error', 'Currently there is no file'];
                return back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error', 'You are not valid User'];
            return back()->withNotify($notify);
        }
    }

    public function appliedMeJob()
    {
        $pageTitle = 'Applied Me Job';
        $jobs = Job::with('jobApplications')
            ->has('jobApplications')
            ->where('owner_id', auth('admin')->id())
            ->where('owner_type', 1)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());
        return view('admin.job.applied_me', compact('pageTitle', 'jobs'));
    }


    public function appliedMeJobProof($id)
    {
        $pageTitle = 'My Submissions';
        $jobApplications = JobApplication::with(['job', 'job.ownerUser', 'job.ownerAdmin'])->where('job_owner_id', auth('admin')->id())->where('job_owner_type', 1)->where('job_id', $id)->paginate(getPaginate());
        foreach ($jobApplications as $item) {
            $item->read_status = 1 ;
            $item->save();
        }
        return view('admin.job.applied_me_job_proof', compact('pageTitle', 'jobApplications'));
    }

    public function jobAppliedAttachmentDownload($id)
    {

        $jobApplication = JobApplication::where('id', $id)->where('job_owner_id', auth('admin')->id())->where('job_owner_type', 1)->first();
        if ($jobApplication) {
            $file = $jobApplication->attachments;
            if ($file) {
                return response()->download($file);
            } else {
                $notify[] = ['error', 'Currently there is no file'];
                return back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error', 'You are not valid User'];
            return back()->withNotify($notify);
        }
    }

    public function jobProofCanceled(Request $request, $id)
    {

        $jobApplication =  JobApplication::with(['job', 'job.ownerUser', 'job.ownerAdmin'])->where('job_owner_id', auth('admin')->id())->where('job_owner_type', 1)->where('id', $id)->first();
        if (!$jobApplication) {
            $notify[] = ['error', 'job id is not valid'];
            return back()->withNotify($notify);
        }
        $request->validate([
            'reason' => 'required|string'
        ]);
        $jobApplication->reason = $request->reason;
        $jobApplication->status = 3;
        $jobApplication->save();

        $notify[] = ['success', 'Job canceled successfully'];
        return back()->withNotify($notify);
    }


    public function jobProofApproved($id)
    {
        $jobApplication =  JobApplication::with(['job', 'job.ownerUser', 'job.ownerAdmin'])->where('job_owner_id', auth('admin')->id())->where('job_owner_type', 1)->where('id', $id)->first();
        if (!$jobApplication) {
            $notify[] = ['error', 'job id is not valid'];
            return back()->withNotify($notify);
        }

        if ($jobApplication->job_holder_type == 2) {
            $user = User::where('id', $jobApplication->job_holder_id)->first();
            $user->balance += $jobApplication?->job->per_worker_earn;
            $user->save();
        }

        $jobApplication->status = 2;
        $jobApplication->save();

        if ($jobApplication->where('job_id', $jobApplication->job_id)->where('status', 2)->count() === $jobApplication->job->quantity) {
            $jobApplication->job->job_status = 2;
            $jobApplication->job->save();
        }

        $notify[] = ['success', 'job Approved successfully'];
        return back()->withNotify($notify);
    }


    public function jobProofAllApproved(Request $request)
    {
 
        $jobApplication =  JobApplication::with(['job', 'job.ownerUser', 'job.ownerAdmin'])->where('job_owner_id', auth('admin')->id())->where('job_owner_type', 1)->where('status', 1)->whereIn('id', $request->ids)->get();
        if ($jobApplication->isNotEmpty()) {
            foreach ($jobApplication ?? [] as $key => $value) {
                if ($value->job_holder_type == 2) {
                    $user = User::where('id', $value->job_holder_id)->first();
                    $user->balance += $value?->job->per_worker_earn;
                    $user->save();
                }
                $value->status = 2;
                $value->save();
                if ($value->where('job_id', $value->job_id)->where('status', 2)->count() === $value->job->quantity) {
                    $value->job->job_status = 2;
                    $value->job->save();
                }
            }
        }

        $jobApplications = JobApplication::with(['job', 'job.ownerUser', 'job.ownerAdmin'])->where('job_owner_id', auth('admin')->id())->where('job_owner_type', 1)->where('job_id', $request->job_id)->paginate(getPaginate());
        $view = view('admin.components.applied_me_job', compact('jobApplications'))->render();
        $data = [
            'status' => "success",
            'data' => $view,
            'message' => "All jobs Approved successfully",
        ];
        return response()->json($data);
    }
}
