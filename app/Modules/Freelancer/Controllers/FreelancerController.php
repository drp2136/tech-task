<?php

namespace App\Modules\Freelancer\Controllers;

use App\Modules\Freelancer\Models\Bid;
use App\Modules\Freelancer\Models\Feedback;
use App\Modules\Freelancer\Models\Jobs;
use App\Modules\Freelancer\Models\Notification;
use App\Modules\Freelancer\Models\Tasks;
use App\Modules\Freelancer\Models\Users;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FreelancerController extends Controller
{
    protected $api_token = null;
    protected $app_url = null;

    public function __construct()
    {
        $this->app_url = env('APP_URL') . '/api';
        $this->api_token = env('API_TOKEN');
    }

    public function login(Request $request)
    {
//        dd('hello');
////      //  === guzzleHTTP_request_hit ===
//        $info['api_token'] = $this->api_token;
//        $client = new Client();
//        $response = $client->request('POST', $this->app_url . '/login', ['form_params' => $info]);
//        $code = $response->getStatusCode();
//
//        if ($code == 200) {
//            $body = $response->getBody();
//            $stringBody = (string)$body;
//            $GuzzleResponse = \GuzzleHttp\json_decode($stringBody);
//            dd('web 33', $GuzzleResponse);
//        }
//
        if ($request->isMethod('post')) {
//            dd($request->all());
//            dd(Hash::make($request->input('password')));
            $rules = [
                'email' => 'required|Email',
                'password' => 'required',
            ];
            $message = [
                'email.required' => 'Please enter your email',
                'password.required' => 'Please enter the password',
            ];
            $validator = Validator::make($request->input(), $rules, $message);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $email = $request->input('email');
                $password = $request->input('password');
                //For Authentication
                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                    $userData = json_decode(json_encode(Auth::user()), true);
//                    dd($userData);
                    if ($userData['status'] == 'A') {
//                        dd($userData['role']);
                        if ($userData['role'] == 'F') {
                            Session::put('freelancer', $userData);
                            return redirect('/profile');
                        } elseif ($userData['role'] == 'E') {
                            Session::put('employer', $userData);
                            return redirect('/employer/profile');
                        } else {
                            return back()->with('error', 'You are not an authorized user to login');
                        }
                    } else {
                        return back()->with('error', 'Your account is not activate yet.!');
                    }
                } else {
//                    return redirect()->back()->withInput();
                    return back()->withInput()->with('error', 'Invalid Credentials !');
                }
            }
        } else {
//            dd(Session::has('freelancer'), 'qqqqqqqqqqqqqqqqqqqqqq77777777777777');
            if (Session::has('freelancer')) {
                return redirect('/profile');
            } else {
                return view('Freelancer::login');
            }
        }
    }

    public function UserLogout()
    {
        Auth::logout();
        Session::forget('freelancer');
        return redirect('/');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
//            dd($request->all());

            $rules = [
                'first_name' => 'required|Min:3|Max:20',
                'email' => 'required|Email|unique:users',
                'password' => 'required|Min:6|Max:32|confirmed',
                'role' => 'required',
            ];
            $message = [
                'first_name.required' => 'Please enter your first name',
                'email.required' => 'Please enter your email',
                'password.required' => 'Please enter your password',
                'role.required' => 'Please select your role',
            ];
            $validator = Validator::make($request->input(), $rules, $message);
            if ($validator->fails()) {
//                dd($request->all());
                return back()->withErrors($validator)->withInput();
            } else {
                $userdata = array();
                $userdata['name'] = $request->input('first_name');
                $userdata['email'] = $request->input('email');
                $userdata['password'] = Hash::make($request->input('password'));
                $userdata['role'] = $request->input('role');
                $userdata['status'] = 'A';
                $userdata['created_at'] = time();
                $userdata['updated_at'] = time();
//                dd($userdata);
                $result = Users::getInstance()->insertQuery($userdata);
                if ($result) {
                    return back()->with('success', 'Registration is Successful.');
                } else {
                    return back()->with('error', 'Something went to wrong.!! Please try later.');
                }
            }
        } else {
            return view('Freelancer::register');
        }
    }

    public function profile(Request $request)
    {
//        dd('Hello');
//        if ($request->isMethod('post')) {
//        } else {

        return view('Freelancer::profile');
//        }
    }

    public function jobslisted(Request $request)
    {
//        dd('jobslisted', Auth::id());
        $where = [
            'rawQuery' => 'status = ?',
            'bindParams' => ['A']
        ];
        $select = ['jobs.job_id', 'jobs.job_heading', 'jobs.job_desc', 'jobs.amnt_offer', 'jobs.created_at'];
        $jobs = Jobs::getInstance()->fetchJobs($where, $select);

        $where = [
            'rawQuery' => 'bid_by = ?',
            'bindParams' => [Auth::id()]
        ];
        $select = ['bid.bid_for_job'];
        $bids = json_decode(json_encode(Bid::getInstance()->fetchBid($where, $select), true));
        $bids = array_column($bids, 'bid_for_job');

//        dd($jobs, $bids, in_array(51, $bids));
        return view('Freelancer::jobs', ['jobs' => $jobs, 'bids' => $bids]);
    }

    public function freelancerAjaxHandler(Request $request)
    {
        if ($request->isMethod('post')) {
            $method = $request->input('method');

            switch ($method) {
                case 'bidJob':
//                    dd('hello ji....... !!!');
                    $bid['bid_by'] = Auth::id();
                    $bid['bid_for_job'] = $request->input('jobId');
                    $bid['bid_amount'] = $request->input('bid_amount');
                    $bid['bid_status'] = 'P';
                    $bid['created_at'] = time();
                    $bid['updated_at'] = time();

                    $result = Bid::getInstance()->insertBid($bid);
                    $response['message'] = 'Some error while bidding, try later.';
                    if ($result) $response['message'] = 'Bid Successful. wait for the response.';
                    return $response;
                    break;

                case 'deleteNotfication':
                    $data = $request->all();
                    unset($data['method']);
                    $where = [
                        'rawQuery' => 'notf_id = ?',
                        'bindParams' => [$data['notf_id']]
                    ];
                    $update = ['notf_status' => 'D'];
                    $updateResp = Notification::getInstance()->updateQuery($where, $update);
                    $resp['message'] = 'Error in deletion. Wait for a while';
                    $resp['status'] = 'error';
                    if ($updateResp) {
                        $resp['message'] = 'Notification deleted successfully.';
                        $resp['status'] = 'success';
                    }
                    return $resp;
                    break;

                case 'changeTaskStatus':
                    $where = [
                        'rawQuery' => 'task_id = ?',
                        'bindParams' => [$request['task_id']]
                    ];
                    $update=['task_status'=>$request['task_status']];
                    $updateTask = json_decode(json_encode(Tasks::getInstance()->updateTasks($where, $update)));

                    return $updateTask;
                    break;

            }
        }
    }

    public function notifications(Request $request)
    {
        $where = [
            'rawQuery' => 'notf_to = ? AND notf_status != ?',
            'bindParams' => [Auth::id(), 'D']
        ];
        $select = ['notifications.notf_id', 'notifications.notf_from', 'notifications.notf_to', 'notifications.notf_mesg',
            'notifications.notf_status', 'notifications.created_at', 'users.name', 'users.email'];

        $notification = json_decode(json_encode(Notification::getInstance()->fetchNotification($where, $select), true));
//        dd($notification);
        return view('Freelancer::notification', ['notification' => $notification]);
    }

    public function myFeedback()
    {
        $where = [
            'rawQuery' => 'to_user = ?',
            'bindParams' => [Auth::id()]
        ];
        $select = ['title', 'desc', 'rating', 'created_at'];
        $feedback = json_decode(json_encode(Feedback::getInstance()->fetchFeedback($where, $select)));

//        dd($feedback);
        return view('Freelancer::feedback', ['feedback' => $feedback]);
    }

    public function checkProgress()
    {
        //fetch and display all the jobs taken and not complete..
        $where = [
            'rawQuery' => 'bid.bid_by = ? AND bid.bid_status = ?',
            'bindParams' => [Auth::id(), 'A']
        ];
        $select = ['jobs.job_id', 'jobs.job_heading', 'jobs.job_desc', 'jobs.status', 'bid.bid_id', 'bid.bid_amount', 'bid.bid_status', 'bid.updated_at'];
        $takenJobs = json_decode(json_encode(Tasks::getInstance()->fetchMyJobs($where, $select)));
        $takenJobs = array_map("unserialize", array_unique(array_map("serialize", $takenJobs)));

        return view('Freelancer::check_progress', ['takenJobs' => $takenJobs]);
    }

    public function checkTheTasks($job_id)
    {
        $where = [
            'rawQuery' => 'for_job_id = ?',
            'bindParams' => [$job_id]
        ];
        $takenJobs = json_decode(json_encode(Tasks::getInstance()->fetchTasks($where)));

        return view('Freelancer::checkTasks', ['takenJobs' => $takenJobs]);
    }

}
