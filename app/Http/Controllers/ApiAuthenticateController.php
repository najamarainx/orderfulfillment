<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiAuthenticateController extends Controller
{
    function invalidTocken(Request $request) {
        $output = [
            'status' => "fail",
            'code' => "401",
            'message' => "your token has been expire please contact to admin"
        ];
        return response()->json($output);
    }
}
