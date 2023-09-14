<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Mail;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\validateCaptcha;
use Illuminate\Http\Request;
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
    protected $redirectTo = RouteServiceProvider::HOME;



    public function showRegistrationForm()
    {
        $allServices = Service::all();
        // Notice the second argument
        return view('auth.register', ['allServices' => $allServices]);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => [ 'max:15'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => 'required_with:password|same:password|min:6',
            'g-recaptcha-response' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
		$user = User::orderBy('id','DESC')->first();
		$x = (now()->year*1000)+ $user->id;
		//$data['code']=$x;
        /*return User::create([
            'user_name' => $data['name'],
			'user_code' => $data['code'],
            'email' => $data['email'],
			'user_type_id' => 4,
            'password' => Hash::make($data['password']),
        ]);*/
		$currentUserEmail = $data['email'];
		$user = new User();
		$user->user_name = $data['name'];
		$user->user_code = $x;
        $user->email = $data['email'];
        $user->phone = $data['phone'];
		$user->user_type_id = 4;
        $user->password = Hash::make($data['password']);
        $captcha_token = $data['g-recaptcha-response'];
        if(strlen($captcha_token) > 0){
            $user->save();
            if (App::environment('production')) {
                // Send email to client after ordering this service
                $email = new \stdClass();
                $email->name =  $user->user_name;
                $email->email =  $user->email;
                \Illuminate\Support\Facades\Mail::send('client.emails.RegisteredEmail', ['email' => $email], function ($message) use ($currentUserEmail) {
                    $message->from('info@easy-trademarks.com','Easytrademark');
                    $message->to($currentUserEmail)->subject('Account registration with Easy Trademarks');
                });
            }
            return $user;
        }
        else{
            return $user;
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect()->intended($this->redirectPath());
    }
}
