<?php

namespace App\Http\Controllers;

use App\Imports\SmsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class SendAttemptsController extends Controller
{

    public function import(Request $request)
    {

        try{
                // Validate that the file has been uploaded and that it is an Excel.
            $request->validate([
                'file' => 'required|mimes:csv,txt,xlsx,xls',
            ]);

            // Get the uploaded file.
            $file = $request->file('file');

            // It imports the file data.
            Excel::import(new SmsImport, $request->file('file'));

            // Redirect with a successful message.
            return redirect('/sms/import')->with('success', 'All good!');

        }catch (\Exception $e){

           // Log the error for debugging purposes.
           Log::error('Error during user import: ' . $e);

        }

    }

    public function index()
    {
        return view('sms_fileimport');
    }

}
