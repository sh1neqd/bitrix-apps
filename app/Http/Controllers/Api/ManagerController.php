<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        return Manager::all();
    }

    public function store(Request $request)
    {
        $manager = Manager::create($request->all());
        return response()->json($manager, 201);
    }
}
