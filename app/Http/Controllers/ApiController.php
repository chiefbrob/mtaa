<?php

namespace Mtaa\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Mtaa\Contact;
use Mtaa\Tip;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function handle($endpoint, Request $request)
    {
    	switch($endpoint){

    		case "register":

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:50',
                    'username' => 'required|string|max:50|unique:users',
                    'email' => 'required|string|email|max:50|unique:users',
                    'gender' => 'required|string|max:10',
                    'phone' => 'required|max:20|unique:users',
                    'password' => 'required|string|min:6'
               ]);

                if ($validator->fails()) {
                    return $validator->messages();
                }

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'remember_token' => str_random(10),
                ]);

                if($user)
                {
                    $user->verifyEmail();
                    return 0;
                }
                return 1;
                
                break;

            case "login":

                $request->validate([
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                    'remember_me' => 'boolean'
                ]);

                $credentials = request(['email', 'password']);

                if(!Auth::attempt($credentials))
                {
                    return 1;
                }
                    

                $user = $request->user();
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(4);
                $token->save();

                return response()->json([
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
                ]);

                break;

            case "logout":
                $request->user()->token()->revoke();
                return 0;
                break;

            case "user":
                if(isset($request->user('api')->id))
                    return response()->json($request->user('api'));
                return 1;
                break;

            case "authenticated":
                return isset($request->user('api')->id) ? 0 : 1;
                break;

            case "updateProfileImage":


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

            case "tip-text":

                $tip = Tip::create([
                    'cat_id' => 1,
                    'description' => $request->content
                ]);

                if($tip)
                    return 0;
                return 1;
                
                break;

    		default:
    			return 1;
    	}
    	
    }

}
