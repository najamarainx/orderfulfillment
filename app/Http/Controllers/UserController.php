<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class UserController extends Controller
{

    public function index()
    {

        return view('users.list');
    }


}
