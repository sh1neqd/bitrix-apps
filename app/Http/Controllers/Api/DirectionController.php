<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use Illuminate\Http\Request;


class DirectionController extends Controller
{
    public function index()
    {
        return Direction::all();
    }

    public function store(Request $request)
    {
        $direction = Direction::create($request->all());
        return response()->json($direction, 201);
    }
}
