<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function helloPost($name, Request $request)
    {
      return response()->json([
        "resultado " => "Hello-post - $name",
        "Request" => $request->all()
      ]);
    }
}
