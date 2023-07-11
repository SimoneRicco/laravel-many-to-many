<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestsPageController extends Controller
{
    public function home()
    {
        return view('guests.home');
    }
}
