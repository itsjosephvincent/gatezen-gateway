<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function import(Request $request): void
    {
        Excel::import(new UserImport, 'users.csv');
    }
}
