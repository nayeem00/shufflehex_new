<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use ReCaptcha\ReCaptcha;
use GuzzleHttp\Client;
use Auth;
use Hash;
use Intervention;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $data;
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $this->data = $data;
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => 'required',
        ];

        $customMessages = [
            'g-recaptcha-response.required' => 'Please complete catcha verification!'
        ];

        $validator = Validator::make($data, $rules, $customMessages);
        $validator->after(function ($validator) {
            $status = $this->passes();
            if ($status == "robot") {
                $validator->errors()->add('g-recaptcha-response', 'Probably you are a robot!');
            }
        });
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function passes()
    {
        $token = isset($this->data['g-recaptcha-response']) ? $this->data['g-recaptcha-response']:"";
        if (!empty($token)) {
            $client = new Client();
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => array(
                    'secret' => "6LfQ57EUAAAAAPbA6TpwVSE9Bo-4q2x_OgQVv5uc",
                    'response' => $token
                )
            ]);
            $results = json_decode($response->getBody()->getContents());
            $this->data = '';
            if ($results->success) {
                return "success";
            } else {
                return "robot";
            }
        } else {

            return "not_found";
        }
    }
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
//        dd($provider);
        $user = Socialite::driver("google")->stateless()->user();
        $authUser = $this->findOrCreateUser($user);
//        return $user->token;
        Auth::login($authUser,true);
        return redirect($this->redirectTo);
    }

    public function findOrCreateUser(Request $request)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $password = substr(str_shuffle(str_repeat($pool, 16)), 0, 16);
        $authUser = User::where('email' , $request->email)->first();

        if(!$authUser){
            $profilePicture = '';
            $miniProfilePicture = '';
            if ($request->image == "") {
            } else {
                $image = $request->image;
                $extension = pathinfo($image, PATHINFO_EXTENSION);
                $ext = explode('?', $extension);
                $profilePicture = 'images/user/profilePicture/' . str_random(4) . '-' . time() . '.' . $ext[0];
//        $file = file_get_contents($info->image);
                $img = Intervention::make($image);
                $resizedImage = $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $save = $resizedImage->save($profilePicture);

                $miniProfilePicture = 'images/user/miniProfilePicture/' . str_random(4) . '-' . time() . '.' . $ext[0];
                $resizedImage = $img->resize(30, 30, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $save = $resizedImage->save($miniProfilePicture);

            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($password);
            $user->profile_picture_link = $profilePicture;
            $user->mini_profile_picture_link = $miniProfilePicture;
            $user->save();
            if(Auth::loginUsingId($user->id)){
                return response()->json(['status'=>'success','user'=>$user]);
            }
        } else {
//            return redirect('/');
            if(Auth::loginUsingId($authUser->id)){
                return response()->json(['status'=>'success','user'=>$authUser]);
            }
        }

    }
}
