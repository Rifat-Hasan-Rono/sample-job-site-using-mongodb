<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Job;
use App\Application;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->status == 0) {
            $jobs = Job::with('applications')->where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);
            $user_ids = [];
            foreach ($jobs as $job) {
                foreach ($job->applications as $application) {
                    $user_id = $application->user_id;
                    if (!in_array($user_id, $user_ids, true)) {
                        array_push($user_ids, $user_id);
                    }
                }
            }
            $users = User::whereIn('_id', $user_ids)->select('_id', 'first_name', 'last_name')->get();
        } else {
            $jobs = Job::with('applications')->orderBy('created_at', 'desc')->paginate(5);
        }
        // print_r(\json_encode($users));
        // exit;
        return view('home')->with(compact('users', 'jobs'));
    }

    public function profileShow()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('profile', compact('user'));
    }

    public function moveFile($file, $target_dir)
    {
        $file_name          = $file->getClientOriginalName();
        $div                = explode('.', $file_name);
        $base_name          = substr($file_name, 0, strrpos($file_name, "."));
        $file_ext           = strtolower(end($div));
        $unique_name        = $base_name . substr(md5(time()), 0, 10);
        $file_full_name     = $unique_name . '.' . $file_ext;
        $file->move($target_dir, $file_full_name);
        return $file_full_name;
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        if (!empty($request->file('picture'))) {
            if (!is_dir(PICTURE)) {
                mkdir(PICTURE, 0777, true);
            }
            if ($user->picture) {
                unlink(PICTURE . $user->picture);
            }
            $user->picture = $this->moveFile($request->file('picture'), PICTURE);
        }

        if (!empty($request->file('resume'))) {
            if (!is_dir(RESUME)) {
                mkdir(RESUME, 0777, true);
            }
            if ($user->resume) {
                unlink(RESUME . $user->resume);
            }
            $user->resume = $this->moveFile($request->file('resume'), RESUME);
        }
        $user->skill         = $request->skill;
        $user->save();
        return redirect()->back()->with(['type' => 'success', 'message' => 'Profile updated successfully']);
    }
}
