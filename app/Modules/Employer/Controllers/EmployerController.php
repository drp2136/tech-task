<?php

namespace App\Modules\Employer\Controllers;

use App\Modules\Employer\Models\Bid;
use App\Modules\Employer\Models\Feedback;
use App\Modules\Employer\Models\Jobs;
use App\Modules\Employer\Models\Notification;
use App\Modules\Employer\Models\Tasks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EmployerController extends Controller
{

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * user log out fucntionality
     */
    public function UserLogout()
    {
        Auth::logout();
        Session::forget('employer');
        return redirect('/');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * after login, go to user profile
     */
    public function profile(Request $request)
    {
        return view('Employer::profile');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * fetch and display my all Jobs
     */
    public function myJobs(Request $request)
    {
        // get the current player jobs..
        $where = [
            'rawQuery' => 'job_by = ?',
            'bindParams' => [Auth::id()]
        ];
        $select = ['jobs.job_id', 'jobs.job_heading', 'jobs.job_desc', 'jobs.status', 'jobs.amnt_offer', 'jobs.created_at'];
        $jobs = json_decode(json_encode(Jobs::getInstance()->fetchJobs($where, $select), true));
        return view('Employer::myJobs', ['jobs' => $jobs]);
    }

    /**
     * @param $jobId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * check the bid details of my uploaded jobs
     */
    public function checkBiddetails($jobId)
    {
        //fetch bids details for a particular job..
        $where = [
            'rawQuery' => 'bid_for_job = ? AND jobs.job_by = ?',
            'bindParams' => [$jobId, Auth::id()]
        ];
        $select = ['bid.bid_id', 'bid.bid_for_job', 'bid.bid_amount', 'bid.bid_status', 'bid.created_at', 'users.name', 'users.email', 'jobs.status'];
        $bids = json_decode(json_encode(Bid::getInstance()->fetchBid($where, $select), true));
        return view('Employer::bidDetails', ['bids' => $bids]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * add or upload a new job
     */
    public function createJob(Request $request)
    {
        if ($request->isMethod('post')) {
            // validation rules for the form inputs..
            $rules = [
                'job_heading' => 'required',
                'job_desc' => 'required',
                'amnt_offer' => 'required',
            ];
            // validation custom error messages..
            $message = [
                'job_heading.required' => 'Please enter job Heading',
                'job_desc.required' => 'Please enter job Desciption',
                'amnt_offer.required' => 'Please enter your offer',
            ];
            // validate the form input..
            $validator = Validator::make($request->input(), $rules, $message);
            if ($validator->fails()) { // if validation failed for any form inputs..
                return back()->withErrors($validator)->withInput();
            } else {
                //get the form-inputs into a variable..
                $addJob = $request->all();
                // remove the _token key-value pair..
                unset($addJob['_token']);
                // add other variable for the jobs..
                $addJob['job_by'] = Auth::id();
                $addJob['status'] = 'A';
                $addJob['created_at'] = time();
                $addJob['updated_at'] = time();

                // insert new jobs..
                $resp = Jobs::getInstance()->insertQuery($addJob);
                if ($resp) return redirect('/employer/my-jobs')->with(['success' => 'Job added Successfully.']);
                else return back();
            }
        } else {
            return view('Employer::createJob');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * all ajax requests
     */
    public function employerAjaxHandler(Request $request)
    {
        //get the ajax request method..
        $method = $request->input('method');
        switch ($method) {
            case 'jobBidAction':
                //get all the inputs into a variable..
                $data = $request->all();
                // remove the input key-value pair method..
                unset($data['method']);
                // to store the DB update value
                $updateResp = false;
                //to run a set of operations within a database transaction,
                // and If an exception is thrown, will automatically be rolled back..
                DB::beginTransaction();
                // update Job status as T=taken..
                $where = [
                    'rawQuery' => 'job_id = ?',
                    'bindParams' => [$data['job_id']]
                ];
                $update = ['status' => 'T'];
                $updateResp = Jobs::getInstance()->updateQuery($where, $update);
                // update Bid status as A=accepted..
                $where = [
                    'rawQuery' => 'bid_id = ? AND bid_for_job = ?',
                    'bindParams' => [$data['bid_id'], $data['job_id']]
                ];
                $update = ['bid_status' => 'A'];
                $updateResp = Bid::getInstance()->updateQuery($where, $update);
                //  response message back to ajax request..
                $resp['message'] = 'Error in Process.';
                $resp['status'] = 'error';
                if ($updateResp) {
                    // on success DB operation, commit the DB action
                    DB::commit();
                    $resp['message'] = 'Bid accepted successfully.';
                    $resp['status'] = 'success';
                } else {
                    // on any error or exception, it will rollback
                    DB::rollback();
                }
                // return the reponse
                return $resp;
                break;

            case 'deleteNotfication':
                //get all the inputs into a variable..
                $data = $request->all();
                // remove the input key-value pair method..
                unset($data['method']);
                // update the notification value..
                $where = [
                    'rawQuery' => 'notf_id = ?',
                    'bindParams' => [$data['notf_id']]
                ];
                $update = ['notf_status' => 'D'];
                $updateResp = Notification::getInstance()->updateQuery($where, $update);
                //  response message back to ajax request..
                $resp['message'] = 'Error in deletion. Wait for a while';
                $resp['status'] = 'error';
                if ($updateResp) {
                    $resp['message'] = 'Notification deleted successfully.';
                    $resp['status'] = 'success';
                }
                // return the reponse
                return $resp;
                break;

            case 'changeTaskStatus':
                $where = [
                    'rawQuery' => 'task_id = ?',
                    'bindParams' => [$request['task_id']]
                ];
                $update = ['task_status' => $request['task_status']];
                $updateTask = json_decode(json_encode(Tasks::getInstance()->updateTasks($where, $update)));

                return $updateTask;
                break;

        }
    }

    public function checkTheTasks($job_id)
    {
        $where = [
            'rawQuery' => 'tasks.for_job_id = ? AND jobs.job_by = ?',
            'bindParams' => [$job_id, Auth::id()]
        ];
        $takenJobs = json_decode(json_encode(Tasks::getInstance()->fetchTasks($where)));
//        dd($takenJobs);

        return view('Employer::checkTasks', ['takenJobs' => $takenJobs, 'job_id'=>$job_id]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * fetch and display all notification for that user
     */
    public function notifications()
    {
        // fetch the notification for employer..
        $where = [
            'rawQuery' => 'notf_to = ? AND notf_type = ? AND notf_status != ?',
            'bindParams' => [Auth::id(), 'M', 'D']
        ];
        $select = ['notifications.notf_id', 'notifications.notf_from', 'notifications.notf_to', 'notifications.notf_mesg',
            'notifications.notf_status', 'notifications.created_at', 'users.name', 'users.email'];

        $notification = json_decode(json_encode(Notification::getInstance()->fetchNotification($where, $select), true));
        return view('Employer::notification', ['notification' => $notification]);
    }

    /**
     * @param Request $request
     * @param $job_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * post or upload a feedback for a freelancer
     */
    public function postFeedback(Request $request, $job_id)
    {
        if ($request->isMethod('post')) {
            // validation rules for the form inputs..
            $rules = [
                'heading' => 'required',
                'description' => 'required',
                'rating' => 'between:1,5',
            ];
            // validate the form input..
            $validator = Validator::make($request->input(), $rules);
            if ($validator->fails()) { // if validation failed for any form inputs..
                return back()->withErrors($validator)->withInput();
            } else {
                // fetch the bidding details for the job..
                $where = [
                    'rawQuery' => 'bid_for_job = ? AND bid_status = ?',
                    'bindParams' => [$job_id, 'A']
                ];
                $select = ['bid.bid_id', 'bid.bid_by', 'bid.bid_for_job', 'bid.bid_amount', 'bid.bid_status', 'bid.created_at'];
                $bidDetails = json_decode(json_encode(Bid::getInstance()->fetchBid($where, $select)[0]), true);
                //process for insert a feedback..
                $feedback['by_user'] = Auth::id();
                $feedback['to_user'] = $bidDetails['bid_by'];
                $feedback['title'] = $request->input('heading');
                $feedback['desc'] = $request->input('description');
                $feedback['rating'] = $request->input('rating');
                $feedback['created_at'] = time();
                $feedback['updated_at'] = time();

                $resp = Feedback::getInstance()->insertQuery($feedback);
                if ($resp) return redirect('/employer/my-jobs')->with(['success' => 'Feedback sent Successfully.']);
                else return back();
            }
        } else {
            return view('Employer::feedback');
        }
    }

    public function createTask(Request $request, $job_id)
    {
        if($request->isMethod('post')){
            // validation rules for the form inputs..
            $rules = [
                'task_name' => 'required',
                'task_desc' => 'required',
                'task_type' => 'required',
            ];
            // validation custom error messages..
            $message = [
                'task_name.required' => 'Please enter task name',
                'task_desc.required' => 'Please enter task Desciption',
                'task_type.required' => 'Please enter task type',
            ];
            // validate the form input..
            $validator = Validator::make($request->input(), $rules, $message);
            if ($validator->fails()) { // if validation failed for any form inputs..
                return back()->withErrors($validator)->withInput();
            } else {
                //get the form-inputs into a variable..
                $addTask = $request->all();
//                dd($addTask, $job_id);
                // remove the _token key-value pair..
                unset($addTask['_token']);
                // add other variable for the jobs..
                $addJob['for_job_id'] = $job_id;
                $addJob['task_name'] = $request->input('task_name');
                $addJob['task_desc'] = $request->input('task_desc');
                $addJob['task_assign_by'] = 'E';
                $addJob['task_status'] = 'A';
                $addJob['task_category'] = $request->input('task_type');
                $addJob['created_at'] = time();
                $addJob['updated_at'] = time();

//                dd($addJob);
                // insert new jobs..
                $resp = Tasks::getInstance()->insertQuery($addJob);
                if ($resp) return redirect('/employer/check-tasks/'.$job_id)->with(['success' => 'Task added Successfully.']);
                else return back();
            }
        }else{
            return view('Employer::createTask');
        }
    }

}

