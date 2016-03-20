<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\user;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Socialite;

class SocialController extends Controller
{
    public function __construct(){
//        $this->middleware('guest');
    }

    private $newMember = false;


    public function getSetup(){
        return view('pages.setup');
    }

    public function getSocialAuth($provider=null){

        if(!config("services.$provider")) abort('404');

        return Socialite::driver($provider)->redirect();
    }



    public function getSocialAuthCallback($provider=null){

        if($user = Socialite::driver($provider)->user()){

            $authUser = $this->findOrCreateUser($user);

            Auth::login($authUser);


            if($this->newMember){
                return redirect()->route('setup');
            }else{
                return redirect()->route('dashboard');
            }


        }else{
            return 'Error';
        }

    }


    private function findOrCreateUser($googleUser)
    {

        if(Auth::attempt(['google_id' => $googleUser->getId(), 'password' => $googleUser->getId() ])){
            $authUser = User::where('google_id', $googleUser->getId())->first();
            $this->newMember = false;
            return $authUser;
        }else{

            $authUser = new User();
            $authUser->email = $googleUser->getEmail();
            $authUser->name = $googleUser->getName();
            $authUser->google_id = $googleUser->getId();
            $authUser->avatar = $googleUser->getAvatar();
            $authUser->password = bcrypt($googleUser->getId());

            $authUser->save();

            $this->newMember = true;

            return $authUser;
        }


//        if ($authUser = User::where('google_id', $googleUser->getId())->first()) {
//            return $authUser;
//        }else{
//
//            $authUser = new User();
//            $authUser->email = $googleUser->getEmail();
//            $authUser->name = $googleUser->getName();
//            $authUser->google_id = $googleUser->getId();
//            $authUser->avatar = $googleUser->getAvatar();
//            $authUser->password = bcrypt($googleUser->getId());
//
//            $authUser->save();
//
//            return $authUser;
//        }


    }


    public function getLogout(){
        Auth::logout();
        return redirect()->route('home');
    }


    public function goToHome(){
        if(Auth::user() != null){
            return redirect()->route('dashboard');
        }
        return view('pages.home');
    }

    public function roleSetRole(Request $request){

//        $this->validate($request,[
//            'title' => 'required',
//            'description' => 'required',
//            'format' => 'required'
//        ]);

        $user = Auth::user();
        $user->user_role = $request['user-role'];
        $user->update();

        return redirect()->route('dashboard');
    }
}
