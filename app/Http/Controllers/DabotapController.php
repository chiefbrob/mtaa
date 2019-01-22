<?php

namespace Dabotap\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Dabotap\Term;

class DabotapController extends Controller
{
    public function pwa($page = 'welcome', Request $request)
    {
    	return view('pwa')
    			->with('page',$page)
    			->with('terms',Term::all());
    }
}
