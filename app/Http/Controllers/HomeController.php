<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Models\User;

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
        return view('home');
    }

    public function sendMail()
    {
        $user =  User::find(1);
        $details = [];
        $details['to'] = User::all()->pluck('email')->toArray();
        $details['title'] = "test title";
        $details['subject'] = "test subject";
        $details['message'] = "test message";

        foreach ($details['to'] as $email) {
            SendMailJob::dispatch($details, $email, $user)->onQueue('email');
            SendMailJob::dispatch($details, $email, $user)->onQueue('default');
        }

        return response("Email was sent!",
         201);
    }
}
