<?php

namespace Mtaa\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mtaa\Term;

class DabotapController extends Controller
{
    public function pwa($page = 'welcome', Request $request)
    {
    	return 'Website coming soon. Hang in there';
    	return view('pwa')
    			->with('page',$page)
    			->with('terms',Term::all());
    }
}
