<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPanel extends Controller
{
    public function Insex(Request $request){
        return view('PanelAdmin');
    }
}
