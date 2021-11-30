<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Zip;
use Carbon\Carbon;
use Auth;
class ZipController extends Controller
{
    public function index()
    {

        return view('zips.list');
    }
}
