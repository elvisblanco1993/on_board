<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Invite;
use App\Orientation;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
        $this->allowedDomains = DB::table('whitelist')->pluck('domain')->all();

        if ( count( $this->allowedDomains ) > 0 ) {
            Validator::extend('allowed_domains', function($attribute, $value, $parameters, $validator) {
                return in_array(explode('@', $value)[1], $this->allowedDomains);
            }, 'Domain not valid for registration.');

            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'allowed_domains'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        /**
         * Make first registered user the Administrator
         */
        if ($user->id === 1) {
            // Assign administrator role
            $role = Role::find(1);
        } else {
            // Assign student role
            $role = Role::find(3);
        }

        $user->roles()->save($role);


        /**
         * Assign orientation
         */
        if ( ! is_null( Orientation::find(request('orientation')) ) ) {
            $user->orientations()->sync(request('orientation'), false);
        }

        /**
         * Delete invitation
         */
        if ( ! is_null( Invite::where('email', $data['email'])->first() ) ) {
            Invite::where('email', $data['email'])->first()->delete();
        }

        return $user;

    }
}
