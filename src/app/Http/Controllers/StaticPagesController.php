<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class StaticPagesController extends Controller
{
    //
    public function home(Request $request)
    {
        return response()->json($request->server());
    }

    public function help(Request $request)
    {
        return response()->json([
            'server'=>$request->server(),
            'path'=>$request->path()
        ]);
    }

    public function about(Request $request)
    {
        return response()->json($request->server());
    }
}
