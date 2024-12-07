<?php

namespace App\Http\Controllers;

use App\Models\SendAttempt;
use Illuminate\Http\Request;

class SmsController extends Controller
{


    public function indexIndividualSMS()
    {
        return view('sms_individual');
    }


    public function index_smsview() {
        $sendAttempts = SendAttempt::paginate(15);
        return view('sms_attemptview', compact('sendAttempts'));
    }

}
