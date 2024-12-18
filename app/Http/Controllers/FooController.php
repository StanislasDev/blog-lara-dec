<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class FooController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('useless', except:['index'])
        ];
    }

    public function index()
    {
        return view('welcome');
    }
}
