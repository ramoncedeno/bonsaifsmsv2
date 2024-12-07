<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function export()
    {
        // Exports data from the UsersExport class to an Excel file named 'users.xlsx'.
        return Excel::download(new UsersExport, 'users.xlsx');
    }

       public function import(Request $request)
    {

        try{
                // Validate that the file has been uploaded and that it is an Excel.
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);

            // Get the uploaded file.
            $request->file('file');

            // It imports the file data.
            Excel::import(new UsersImport, $request->file('file'));

            // Redirect with a successful message.
            return redirect('/users/import')->with('success', 'All good!');

        }catch (\Exception $e){

           // Log the error for debugging purposes.
           Log::error('Error during user import: ' . $e->getMessage());

        }

    }

    public function index()
    {
        return view('users_import');
    }

}
