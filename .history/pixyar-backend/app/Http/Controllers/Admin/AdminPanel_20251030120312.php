<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function Index(Request $request){
        return view('admin.PanelAdmin');
    }
}
