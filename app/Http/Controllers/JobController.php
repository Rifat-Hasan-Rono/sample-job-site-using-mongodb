<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Application;
use Auth;

class JobController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function show($id = false)
    {
        $job = false;
        $form = "Add Job";
        if ($id) {
            $form = "Edit Job";
            $job = Job::findOrFail($id);
        }
        return view('job', compact('job', 'form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required',
            'description'   => 'required',
            'salary'    => 'required',
            'location'  => 'required',
            'country'   => 'required',
        ]);
        if ($request->id) {
            $job = Job::findOrFail($request->id);
            $job->title = $request->title;
            $job->description = $request->description;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->country = $request->country;
        } else {
            $job = new Job($request->all());
            $job->created_by = Auth::user()->id;
        }
        $job->save();
        return redirect()->back()->with(['type' => 'success', 'message' => 'Saved successfully']);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function apply($id)
    {
        if (Auth::user()->resume) {
            $application = new Application();
            $application->job_id  = $id;
            $application->user_id = Auth::user()->id;
            $application->save();
            return redirect()->back()->with(['type' => 'success', 'message' => 'Applied successfully']);
        } else {
            return redirect()->back()->with(['type' => 'warning', 'message' => 'Please upload your resume first']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Application::where('job_id', $id)->delete();
        $data = Job::destroy($id);
        if ($data) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return redirect()->back()->with(['type' => 'warning', 'message' => 'Please try again']);
        }
    }
}
