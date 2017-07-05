<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Log;
use Junaidnasir\Larainvite\Facades\Invite;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/eason';

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
      $res = Validator::make($data, [
          'name' => 'required|max:255|unique:users',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
          'invite_code' => 'required',
          'phone' => 'required|unique:users'
      ]);
        return $res;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      // Log::info("create");
      //   Log::info($data);
        $code = $data['invite_code'];
        if(Invite::isAllowed($code,$data['email']))
        {

          $invitation = Invite::get($code);
          $user = User::create([
              'name' => $data['name'],
              'email' => $data['email'],
              'phone' => $data['phone'],
              'app_id' => $invitation->app_id,
              'code' => $invitation->regioncode,
              'password' => bcrypt($data['password']),
          ]);
          $bcode = $user->bcode()->first();
          if(count($user->codes()->where('id',$bcode->id)->get()) == 0){
            $user->codes()->attach($bcode->id);
          }
          if(sizeof($bcode->roles()->get()) == 0){
            Artisan::call('code:roles',['code_id'=> $code->id]);
          }
          $role = $bcode->roles()->where('name','=','app_user')->first();
          if(count($user->roles()->where('id',$role->id)->get()) == 0){
            $user->roles()->attach($role->id);
          }
          Invite::consume($code);
          return $user;
        }

    }
}
