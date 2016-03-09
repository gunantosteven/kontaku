<?php namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
	use Authenticatable, CanResetPassword;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'email', 'password', 'activation_code', 'active', 'role', 'fullname', 'url', 'phone', 'phone2', 'pinbb', 'facebook', 'twitter', 'instagram', 'line', 'status', 'note', 'showemailinpublic', 'privateaccount','privatephone1','privatephone2', 'newinvitesnotification', 'limitcontacts', 'membertype'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function accountIsActive($code) {
		$user = User::where('activation_code', '=', $code)->first();
		if($user == null)
		{
			return false;
		}
		$user->active = 1;
		$user->activation_code = '';
		if($user->save()) {
			\Auth::login($user);
		}
		return true;
	}

	public function isFriendOnline($id) {
		$friendsonline1 = \DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user1')
            ->select('friendsonline.user1 as id', 'users.fullname as fullname')
            ->where('friendsonline.user2', \Auth::user()->id)
            ->where('friendsonline.user1', $id)
            ->count();
        $friendsonline2 = \DB::table('users')
            ->join('friendsonline', 'users.id', '=', 'friendsonline.user2')
            ->select('friendsonline.user2 as id', 'users.fullname as fullname')
            ->where('friendsonline.user1', \Auth::user()->id)
            ->where('friendsonline.user2', $id)
            ->count();
        $combinedCount = $friendsonline1 + $friendsonline2;

		if($combinedCount > 0)
        {
        	return true;
        }

        return false;
	}
}