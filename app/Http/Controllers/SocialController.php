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


    /**
     * Present first time user with setup page
     *
     *  @return vew()
     */
    public function getSetup(){
        return view('pages.setup');
    }


    /**
     * Present logged in user with dashboard
     *
     *  @return vew()
     */
    public function goToHome(){

        //check if user is logged in present dashboard
        if(Auth::user() != null){
            return redirect()->route('dashboard');
        }

        return view('pages.home');
    }


    /**
     * Log user out
     *
     * @return redirect()
     */
    public function getLogout(){
        Auth::logout();
        return redirect()->route('home');
    }



    /**
     * Socialite make request to google oauth provider
     *
     * @param  $provider
     *
     * @return Socialite
     */

    public function getSocialAuth($provider=null){

        if(!config("services.$provider")) abort('404');

        return Socialite::driver($provider)->redirect();
    }


    /**
     * Socialite receive google oauth provider callback
     *
     * @param  $provider
     *
     * @return redirect()
     */

    public function getSocialAuthCallback($provider=null){

        if($user = Socialite::driver($provider)->user()){

            //Determine if new or returning user and return user in both cases
            $authUser = $this->findOrCreateUser($user);

            //Log user in
            Auth::login($authUser);

            //Route appropriately
            if($this->newMember){
                return redirect()->route('setup');
            }else{
                return redirect()->route('dashboard');
            }


        }else{
            return 'Error';
        }

    }


    /**
     * Find google user in database or create new user
     *
     * @param  $googleUser user returned by google
     *
     * @return User
     */
    private function findOrCreateUser($googleUser)
    {
        // if user does not exist in DB they must be new
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
    }



    /**
     * Set user role at setup Staff/Faculty OR Student
     *
     * @param  $request post request with appropriate role
     *
     * @return redirect()
     */
    public function roleSetRole(Request $request){

        $user = Auth::user();
        $user->user_role = $request['user-role'];
        $user->update();

        return redirect()->route('dashboard');
    }
}
