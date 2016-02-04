<?php namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use Hash;
use Uuid;
use Input;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	protected $redirectTo = '/user/home';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout', 'resendEmail', 'activateAccount']);
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if(strtolower($request->input('url')) == "admin")
		{
			$validator->getMessageBag()->add('url', 'You cannot register with this url name');
			return redirect()->back()->withErrors($validator)->withInput();
		}
		if ($validator->fails())
		{
			$this->throwValidationException(
					$request, $validator
			);
		}
		$activation_code = str_random(60) . $request->input('email');
		$user = new User;
		$user->id = Uuid::generate();
		$user->email = strtolower($request->input('email'));
		$user->password = Hash::make($request->input('password'));
		$user->url = strtolower($request->input('url'));
		$user->fullname = $request->input('fullname');
		$user->activation_code = $activation_code;
		if ($user->save()) {
			
			$this->sendEmail($user);
			
			return view('auth.activateAccount')
				->with('email', $request->input('email'));
		
		} else {
			
			\Session::flash('message', 'Your account could not be create please try again');
			return redirect()->back()->withInput();
			
		}
		
	}

	public function sendEmail(User $user)
 	{
 		$data = array(
				'name' => $user->url,
				'code' => $user->activation_code,
			);
			
		\Mail::queue('emails.activateAccount', $data, function($message) use ($user) {
			$message->from('noreply@kontakku.com', 'Kontakku Team');
			$message->subject('Please activate your account.');
			$message->to($user->email);
		});
 	}

 	public function resendEmail()
	{
		$user = \Auth::user();
		if( $user->active == true )
		{
			return redirect('user\home');
		}
		else if( $user->resent >= 3 )
		{
			return view('auth.tooManyEmails')
				->with('email', $user->email);
		} else {
			$user->resent = $user->resent + 1;
			$user->save();
			$this->sendEmail($user);
			return view('auth.activateAccount')
				->with('email', $user->email);
		}
	}
	
	public function activateAccount($code, User $user)
	{
		if( \Auth::user() != null && \Auth::user()->active == true )
		{
			return redirect('user\home');
		}
		else if($user->accountIsActive($code)) {
			\Session::flash('message', 'Success, your account has been activated.');
			return view('auth.activateAccountSuccess');
		}
		else
		{
			\Session::flash('message', 'Your account could not be activated; please try again.');
			return view('auth.activateAccountError');
		}
	}

	public function postLogin(Request $request)
	{
		Input::merge(array_map('trim', Input::only(array('username'))));
		Input::merge(array('email' => strtolower(Input::get('email'))));
	    $this->validate($request, [
	        'email' => 'required',
	        'password' => 'required',
	    ]);

	    $credentials = $request->only('email', 'password');

	    if ($this->auth->attempt($credentials, $request->has('remember')))
	    {
	    	\DB::table('sessions')->insert(
			    array('id' => Uuid::generate(), 'user' => $this->auth->User()->id, 'sessionId' => \Session::getId())
			);
	        if($this->auth->User()->role == 'ADMIN')
            {
                return redirect('user/home');
            }
            else if($this->auth->User()->role == 'USER')
            {
            	return redirect('user/home');
            }
            else
            {
                //have to log out since our data is cached and we're already logged in but we find the account is inactive !
                $this->auth->logout();
                //now we are logged out, we can redirect with message we want, if we did not log out the middleware recognize us as NON GUEST account !
                return redirect('/auth/login')->withInput($request->only('username'))->withErrors(['email' => 'Your Account is not active',]); 
            }
	    }

	    return redirect($this->loginPath())
	                ->withInput($request->only('username', 'remember'))
	                ->withErrors([
	                    'username' => 'These credentials do not match our records.',
	                ]);
	}

	/**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
    	\DB::table('sessions')->where('user', \Auth::user()->id)->where('sessionId', \Session::getId())->delete();
        $this->auth->logout();
        return redirect('auth/login');
    }

}
