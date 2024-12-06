<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{


    public function indexIndividualSMS()
    {
        return view('sms_individual');
    }

    public function indexImport()
    {
        return view('sms_import');
    }



}
