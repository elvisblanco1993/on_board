<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Settings;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $frontPageContents = Settings::get()[0]->frontpage;

        $frontPage = view('front', [
            'frontPageContents' => $frontPageContents,
        ]);

        // Redirect to Login if no Front Page Contents.
        $goTo = ( ! is_null( $frontPageContents ) ) ? $frontPage : redirect('/login');

        return $goTo;
    }

    /**
     * Show registration by invitation
     */
    public function finishRegistration()
    {
        if ( ! is_null( request('token') ) ) {

            $invite = Invite::where('token', request('token'))->get();

            if ( count( $invite ) === 1 ) {

                return view('auth.finish-registration', [
                    'email' => $invite[0]->email,
                    'orientation' => $invite[0]->orientation,
                ]);

            } else {
                return redirect('/register');
            }
        } else {
            return redirect('/register');
        }
    }
}
