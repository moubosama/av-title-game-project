<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    function index(): View
    {
        return view('index');
    }
}
