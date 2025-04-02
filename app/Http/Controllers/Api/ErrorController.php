<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Error;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function index()
    {
        return Error::all();
    }

    public function store(Request $request)
    {
        $error = Error::create($request->all());
        return response()->json($error, 201);
    }
}
