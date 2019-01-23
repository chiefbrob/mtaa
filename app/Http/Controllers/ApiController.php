<?php

namespace Dabotap\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Dabotap\Contact;

class ApiController extends Controller
{
    public function handle($endpoint, Request $request)
    {
    	switch($endpoint){

    		case "csrf":
                return csrf_token();
                break;

            case "authenticated":
                return Auth::user() ? 0 : 1;
                break;
                
            case "profile":
                return Auth::user() ? Auth::user() : array();
                break;

            case "updateProfileImage":

                dd($request->all());

                if(isset(Auth::user()->id) && $request->hasFile('image')){
                    $user = Auth::user();
                    $image = $request->file('image');
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    Image::make($image)->resize(400, 400)->save( public_path('images/profiles/' . $filename ) );

                    if(file_exists(public_path('images/profiles/'.$user->avatar)))
                    {
                        if($user->avatar !== 'avatar.jpg')
                            unlink(public_path('images/profiles/'.$user->avatar));
                    }

                    $user->avatar = $filename;
                    $user->save();

                    return 0;
                }

                return 1;
                
                break;

            case "updateProfile":
                if(isset(Auth::user()->id))
                {
                    Auth::user()->name = $request->name;
                    Auth::user()->phone = $request->phone;
                    Auth::user()->save();
                    return 0;

                }
                return 1;
                break;

            case "contactUs":

                $c = Contact::create([
                    'names' => $request->name,
                    'email' => $request->email,
                    'message' => $request->message
                ]);

                if($c)
                    return 0;
                return 1;
                
                break;

    		default:
    			return 1;
    	}
    	
    }

}
