<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderFulfillmentSaleLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks.list');
    }
}
