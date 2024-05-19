<?php

namespace App\Http\Controllers\User;

use App\Models\Job;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Cache;

class JobController extends Controller
{

    public function index(Request $request)
    {
        $pageTitle = 'Posted Jobs';
        $jobs = Job::where('owner_id', auth()->id())->where('owner_type', 2)->orderBy('id', "desc")->paginate(getPaginate());

        // initial data delete
        $initialJobs = Job::where('owner_id', auth()->id())->where('owner_type', 2)->where('status', 0)->get();
        foreach ($initialJobs as $key => $job) {
            if (file_exists(getFilePath('job') . '/' . $job->image)) {
                fileManager()->removeFile(getFilePath('job') . '/' . $job->image);
            }
            $job->delete();
        }
        return view($this->activeTemplate . 'user.job.index', compact('pageTitle', 'jobs'));
    }

    public function create()
    {
        $pageTitle = 'Create Job';
        $categories = Category::where('status', 1)->get();
        return view($this->activeTemplate . 'user.job.create', compact('pageTitle', 'categories'));
    }

    public function store(JobRequest $request)
    {
        $pageTitle = 'Create Job';
        $purifier = new \HTMLPurifier();
        $categories = Category::where('id', $request->category_id)->where('status', 1)->first();
        $sub_categories = SubCategory::where('id', $request->sub_category_id)->where('status', 1)->first();
        if (!$categories) {
            $notify[] = ['error', 'Your category is not valid'];
            return back()->withNotify($notify);
        } elseif (!$sub_categories) {
            $notify[] = ['error', 'Your sub category is not valid'];
            return back()->withNotify($notify);
        }

        $job = new Job();
        $job->owner_id = auth()->id();
        $job->owner_type = 2;
        $job->title = $request->title;
        $job->category_id = $request->category_id;
        $job->sub_category_id = $request->sub_category_id;
        $job->title = $request->title;
        $job->unique_id = Str::upper(Str::random(3) . time() . getTrx(3));
        $job->image = fileUploader($request->image, getFilePath('job'), getFileSize('job'));
        $job->quantity = $request->quantity;
        $job->description = $purifier->purify($request->description);
        $total_budge = ($request->quantity * $request->per_worker_earn);
        $job->total_budge = number_format($total_budge,2);
        $job->per_worker_earn = $request->per_worker_earn;
        $job->avg_time = $request->avg_time;
        $job->status = 0;
        if ($request->hasFile('image')) {
            try {
                $job->image = fileUploader($request->image, getFilePath('job'), getFileSize('job'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $job->save();
        session()->forget('job');
        session()->put('job', $job);
        return to_route('user.deposit');
    }

    public function subCategorySearch(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();
        $data = [
            'status' => "success",
            'data' => $subCategories,
        ];
        return response()->json($data);
    }

    public function delete($id)
    {
        $pageTitle = 'Delete Job';
        $job = Job::where('id', $id)->first();
        if (file_exists(getFilePath('job') . '/' . $job->image)) {
            fileManager()->removeFile(getFilePath('job') . '/' . $job->image);
        }
        $job->delete();
        $notify[] = ['success', 'Job Delete successfully'];
        return back()->withNotify($notify);
    }

    function jobStatus(Request $request)
    {
        $pageTitle = 'Status Job';
        // Check job is valid or not
        $job = Job::where('id', $request->job_id)->where('owner_id', auth()->id())->where('owner_type', 2)->first();
        if (!$job) {
            $notify[] = ['error', 'Your job is not valid'];
            return back()->withNotify($notify);
        }
        if (in_array($request->status_data, [0, 1, 2])) {

            // Check job status is valid or not
            if ($job->job_status == 2) {
                $notify[] = ['error', 'Your job already finished'];
                return back()->withNotify($notify);
            }

            // without ajax
            if ($request->status_data == 2) {
                $job->job_status = $request->status_data;
                $job->save();
                $notify[] = ['success', 'Job status in updated'];
                return back()->withNotify($notify);
            } else {
                $job->job_status = $request->status_data;
                $job->save();
                $notify[] = ['success', 'Job status in updated'];
                return back()->withNotify($notify);
            }
        } else {

            $notify[] = ['error', 'Your job status is not valid'];
            return back()->withNotify($notify);
         
        }
    }
}
