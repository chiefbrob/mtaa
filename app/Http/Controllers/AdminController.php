<?php

namespace Mtaa\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function handle($endpoint, Request $request)
    {

    	$user = Auth::user();

    	if(!$user->isAnAdmin())
    		return redirect('/');
    	
    	switch($endpoint){

    		case 'home':
    			return view('admin.home');
    			break;


    		default:
    			return 1;
    	}
    }
}
