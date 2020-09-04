<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Orientation;
use App\Invite;
use App\Mail\InviteEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $role = User::find(Auth::user()->id)->getRoles();


        // $students = User::whereHas("roles", function($q){
        //     $q->where("name", "student");
        // })->doesntHave('orientations')->get();

        $students = User::whereHas("roles", function($q){
            $q->where("name", "student");
        })->get();

        // IS AN ADMIN
        if ($role->contains('admin')) {

            $orientations = Orientation::all();
            return view('dashboards.admin', [
                'user' => $user,
                'orientations' => $orientations,
                'role' => $role,
                'students' => $students
                ]);

        }

        // IS AN ADVISOR
        if ($role->contains('advisor')) {
            $orientations = Orientation::all();

            return view('dashboards.advisor', [
                'user' => $user,
                'orientations' => $orientations,
                'role' => $role,
                'students' => $students
            ]);
        }

        // IS A STUDENT
        if ($role->contains('student')) {

            $orientations = $user->orientations;
            $sections = $user->sections;
            $documents = User::find(Auth::user()->id)->documents;

            $first = DB::table('section_user')->where('user_id', $user->id)->first();
            $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $bgcolor = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];

            return view('student.index', [
                'user' => $user,
                'orientations' => $orientations,
                'cardBg' => $bgcolor,
                'documents' => $documents,
            ]);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created user in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // return view('dashboards.admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = Auth::user();
        $role = User::find(Auth::user()->id)->getRoles();

        return view('my', [
            'user' => $user,
            'role' => $role
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function updateAvatar()
    {
        $user = User::find(Auth::user()->id);

        request()->validate([
            'avatar' => 'required|mimes:png,jpg,jpeg'
        ]);

        // Deletes the old image
        if ($user->avatar) {
            Storage::disk('public')->delete('images/' . $user->avatar);
        }

        // Upload the new avatar
        $avatar = request()->file('avatar');
        $avatar->store('images', 'public');

        $user->avatar = $avatar->hashName();

        $user->update();

        return redirect()->route('my')
            ->with('message', 'Your avatar was successfully updated.');

    }


    /**
     * Update user password
     */
    public function updatePassword()
    {
        $user = User::find( Auth::user()->id );

        request()->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make( request('password') );

        $user->update();

        return redirect()->route('my')
            ->with('message', 'Your password was successfully updated.');

    }

    /**
     * Invite users
     */
    public function invite()
    {
        return view('users.invite', [
            'role' => User::find(Auth::user()->id)->getRoles(),
            'orientations' => Orientation::all()
        ]);
    }

    /**
     * Process invitations
     */
    public function processInvites()
    {
        // Validate form data
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:invites'],
        ]);
        // Submit data to DB
        $invite = new Invite();

        $invite->name   = request('name');
        $invite->email  = request('email');
        $invite->orientation = ( ! is_null( request('orientation') ) ) ? request('orientation') : 0;
        $invite->token  = Str::random(20);

        $invite->save();

        // Generate URL that's going to be sent to user
        $url = URL::signedRoute(
            'register.finish', ['token' => $invite->token]
        );

        Mail::to( $invite->email )->queue( new InviteEmail($invite->name, $url) );

        return redirect()->route('users')->with('message', 'Invitations were successfully sent.');
    }

    /**
     * Resend invitation
     */
    public function resendInvite(Invite $invitee)
    {
        $url = URL::signedRoute(
            'register.finish', ['token' => $invitee->token]
        );

        Mail::to( $invitee->email )->queue( new InviteEmail($invitee->name, $url) );

        return redirect()->route('users')->with('message', 'Invitation was successfully re-sent.');
    }

    /**
     * Delete invitee
     */
    public function deleteInvitee(Invite $invitee)
    {
        $invitee->delete();
        return redirect()->route('users')->with('message', 'Invitee was successfully removed from the system.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
