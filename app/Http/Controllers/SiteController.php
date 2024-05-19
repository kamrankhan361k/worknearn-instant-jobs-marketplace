<?php

namespace App\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\Page;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\JobApplication;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function about()
    {
        $pageTitle = "About";
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'about')->firstOrFail();
        return view($this->activeTemplate . 'about', compact('pageTitle', 'sections'));
    }

    public function jobs(Request $request)
    {
        $pageTitle = "Jobs";
        $categories = Category::with('subCategories')->where('status', 1)->get();
        $jobs = Job::where('job_status', 1)->where('status', 1);
        if ($request->search) {
            $search = $request->input('search');
            $jobs->where('title', 'LIKE', "%$search%");
        }

        if ($request->categories) {
            $requestCategories = $request->input('categories');
            $jobs->orWhere('category_id', $requestCategories);
        }

        if ($request->sub_category) {
            $requestSubCategories = $request->input('sub_category');
            $jobs->orWhere('sub_category_id', $requestSubCategories);
        }
        $jobs = $jobs->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'job.jobs', compact('pageTitle', 'jobs', 'categories'));
    }

    public function jobFiltered(Request $request)
    {
        // dd($request->all());
        $search = $request->input('search');
        $minTime = $request->input('minTime');
        $maxTime = $request->input('maxTime');
        $paymentMin = $request->input('paymentMin');
        $paymentMax = $request->input('paymentMax');
        $requestSubCategories = $request->input('subCategories', []);
        $query = Job::whereStatus(1)->where('job_status', 1);
        $categories = Category::where('status', 1)->get();
        if (!empty($requestSubCategories)) {
            $query->whereIn('sub_category_id', $requestSubCategories);
        } else {
            $query->get();
        }
        // $jobs = $query->orderBy('id', 'desc')->get();
        // dd($jobs,$request->all(),$requestSubCategories);

        if ($search) {
            $query->where('title', 'LIKE', "%$search%");
        }

        if ($minTime && $maxTime) {

            $query->where('avg_time', '>=', "$minTime")->where('avg_time', '<=', "$maxTime");
        }

        if ($paymentMin && $paymentMax) {
            $query->where('per_worker_earn', '>=', "$paymentMin")->where('per_worker_earn', '<=', "$paymentMax");
        }

        $jobs = $query->orderBy('id', 'desc')->paginate(getPaginate());
        // dd($jobs);
        $view = view('presets.default.components.jobs_list', compact('jobs'))->render();
        return response()->json([
            'html' => $view
        ]);
    }

    public function jobDetails($id, $title)
    {
        $pageTitle = "Job Details";
        $job = Job::with('ownerUser', 'ownerAdmin')->where('id', $id)->where('status', 1)->first();
        return view($this->activeTemplate . 'job.job_details', compact('pageTitle', 'job'));
    }

    // job request store
    public function jobApplicationStore(Request $request, $job_id)
    {
        $userType = 0;
        if (auth()->guard('admin')->check()) {
            $userType = 1;
        } elseif (auth()->guard('web')->check()) {
            $userType = 2;
        } else {
            $notify[] = ['error', 'Please login first'];
            return to_route('user.login')->withNotify($notify);
        }

        $job = Job::where('id', $job_id)->where('job_status', 1)->where('status', 1)->first();

        if (!$job) {
            $notify[] = ['error', 'Your job is finished'];
            return back()->withNotify($notify);
        }

        $existingRunningUser = JobApplication::where(function ($query) {
            $query->where("job_holder_id", auth('admin')->id())
                ->where('job_holder_type', 1)
                ->orWhere("job_holder_id", auth()->id())
                ->where('job_holder_type', 2);
        })->where('job_id', $job_id)
            ->whereIn('status', [0, 1])
            ->first();



        if ($existingRunningUser) {
            $notify[] = ['error', 'Your are running job holder for this job'];
            return back()->withNotify($notify);
        } else {
            $jobApplication = new JobApplication();
            $jobApplication->job_id = $job_id;
            $jobApplication->job_owner_id = $job->owner_id;
            $jobApplication->job_owner_type = $job->owner_type;
            $jobApplication->job_holder_id = auth('admin')->id() ?? auth()->id();
            $jobApplication->job_holder_type =  $userType;
            $jobApplication->status = 0;
            $jobApplication->save();
            $notify[] = ['success', 'Now your are starting your Job'];
            return back()->withNotify($notify);
        }
    }

    // job proof store
    public function jobProofStore(Request $request, $job_id)
    {
        $job = Job::where('id', $job_id)->where('job_status', 1)->where('status', 1)->first();
        if (!$job) {
            $notify[] = ['success', 'Your job is not valid'];
            return back()->withNotify($notify);
        }

        //  Admin and User check, is he job holder for this job?
        if (auth()->guard('admin')->check()) {
            $query = JobApplication::where('job_id', $job_id)->where("job_holder_id", auth('admin')->id())->where('job_holder_type', 1);
            $existJobApplication = $query->where('status', '=', 0)->first();
            $existPendingJobApplication = $query->where('status', '=', 1)->first();

            if (!$existJobApplication) {
                $notify[] = ['error', 'At first start this Job'];
                return back()->withNotify($notify);
            } elseif ($existPendingJobApplication) {
                $notify[] = ['error', 'Your job documents already pending'];
                return back()->withNotify($notify);
            }
        } elseif (auth()->guard('web')->check()) {
            $query = JobApplication::where('job_id', $job_id)->where("job_holder_id", auth('web')->id())->where('job_holder_type', 2);

            $existJobApplication = $query->where('status', '=', 0)->first();
            $existPendingJobApplication = $query->where('status', '=', 1)->first();

            if (!$existJobApplication) {
                $notify[] = ['error', 'At first start this Job'];
                return back()->withNotify($notify);
            } elseif ($existPendingJobApplication) {
                $notify[] = ['error', 'Your job documents already pending'];
                return back()->withNotify($notify);
            }
        } else {

            return to_route('user.login');
        }
        $request->validate([
            'description' => 'required',
            'attachments' => 'required|array',
            'attachments.*' => 'file|mimes:jpg,png,webp,xlsx,xls,application/xml,text/xml,text/plain,text/html,pdf,doc,docx,csv'
        ]);

        $path = '/' . date("Y") . '/' . date("m") . '/';
        $date = now()->format('h_m_s');
        if (!file_exists(getFilePath('job_attachment') . $path)) {
            mkdir(getFilePath('job_attachment') . $path, 0755, true);
        }

        $destination = getFilePath('job_attachment') . $path . 'job_attachment' . '_' . $date . '.zip';

        if ($this->compressFilesFromRequest($request, $destination)) {
            $existJobApplication->attachments = $destination;
        } else {
            $notify[] = ['error', 'something went wrong'];
            return back()->withNotify($notify);
        }
        $purifier = new \HTMLPurifier();
        $existJobApplication->description = $purifier->purify($request->description);
        $existJobApplication->status = 1;
        $existJobApplication->save();
        $notify[] = ['success', 'Your job proof create successfully'];
        return back()->withNotify($notify);
    }

    // job file zip
    public function compressFilesFromRequest(Request $request, $destination)
    {
        $zip = new ZipArchive;
        if ($zip->open($destination, ZipArchive::CREATE) === true) {
            // Retrieve the uploaded files from the request
            $files = $request->file('attachments');

            // Iterate over each uploaded file
            foreach ($files as $file) {
                // Add the file to the ZIP archive
                $zip->addFile($file->getPathname(), $file->getClientOriginalName());
            }
            $zip->close();
            return true; // Compression successful
        }
        return false; // Failed to create ZIP file
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:subscribers',
        ]);
        $subscribe = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();
        $notify[] = ['success', 'You have successfully subscribed to the Newsletter'];
        return back()->withNotify($notify);
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogPost()
    {
        $pageTitle = 'Blog';
        $blogSection = Frontend::where('data_keys', 'blog.content')->first();
        $blogElementSection = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(getPaginate(6));
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->firstOrFail();
        return view($this->activeTemplate . 'blog.blog-post', compact('pageTitle', 'blogSection', 'blogElementSection', 'sections'));
    }


    public function blogDetails($slug, $id)
    {
        $blog = Frontend::findOrFail($id);
        $blogElementSection = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->take(4)->get();
        $pageTitle = 'Blog Details';
        return view($this->activeTemplate . 'blog.blog-details', compact('pageTitle', 'blog', 'blogElementSection'));
    }

    public function blogSearch(Request $request)
    {
        $blogs = Frontend::where('data_keys', 'blog.element')->where('data_values->title', 'like', "%$request->searchTerm%")->get();
        $data = [
            'status' => "success",
            'blogs' => $blogs,
        ];
        return response()->json($data);
    }


    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
}
