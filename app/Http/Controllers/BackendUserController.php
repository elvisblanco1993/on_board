<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\BackendUser;
use App\Invite;
use App\Orientation;
use App\User;
use App\Role;
use Illuminate\Http\Request;

class BackendUserController extends Controller
{
    /**
     * Retrieve all users
     */
    public function index()
    {
        $role = User::find(Auth::user()->id)->getRoles();
        $users = User::paginate('10');
        $pendingInvites = Invite::all();

        return view('users.index', [
            'role' => $role,
            'users' => $users,
            'appRoles' => Role::get(),
            'pendingInvites' => $pendingInvites
        ]);
    }

    /**
     * Update user
     */
    public function update(User $user)
    {
        if (User::find($user->id)) {
            // Validating user information
            request()->validate(['name' => 'required|string']);

            // Update user information
            $user->name = request('name');
            $user->save();

            $user->roles()->detach();
            $user->roles()->attach(request('role'));

            // Redirect back to users view
            return redirect(route('users'))->with('message', 'The user ' . $user->name . ' was successfully updated.');
        }
        return redirect(route('users'))->with('errMessage', 'Unauthorized action recorded.');
    }

    /**
     * View single user details
     */
    public function view(User $user)
    {
        $orientations = $user->orientations ?? null;
        $documents = $user->documents ?? null;

        return view('users.view', [
            'user' => $user,
            'orientations' => $orientations,
            'documents' => $documents,
            'appRoles' => Role::get(),
            'role' => User::find(Auth::user()->id)->getRoles(),
        ]);
    }
}
