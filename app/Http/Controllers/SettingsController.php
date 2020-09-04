<?php

namespace App\Http\Controllers;

use App\Settings;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show all settings
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $role = $user->getRoles();
        $settings = Settings::first() ?? null;
        $whitelist = DB::table('whitelist')->get();

        if ($role->contains('admin')) {

            return view('settings.index', [
                'user' => $user,
                'role' => $role,
                'settings' => $settings,
                'whitelist' => $whitelist,
            ]);

        } else {
            return redirect('/');
        }
    }

    /**
     * Update the company details
     * @return string
     */
    public function detailsUpdate()
    {
        $settings = Settings::first();
        // Verify each separate item.
        // Don't use built in validate(), cause all input is not required.

        if (request('company_name')) {
            $settings->school_name = request('company_name');
        }

        if (request('company_phone')) {
            $settings->phone = request('company_phone');
        }

        if (request('company_email')) {
            $settings->email = request('company_email');
        }

        if (request('company_address')) {
            $settings->address = request('company_address');
        }

        $settings->update();

        return redirect()->route('settings')->with('message', 'Company details were successfully updated.');

    }

    /**
     * Update the company logo
     *
     * @return redirect
     */
    public function logoUpdate()
    {
        request()->validate([
            'logo' => 'mimes:png|max:2000'
        ]);

        $settings = Settings::first();
        // Logo manipulation
        $settings->school_logo = request('logo');

        if ($settings->school_logo) {

            $original_logo = $settings->getOriginal('logo');
            Storage::disk('public')->delete('images/' . $original_logo);

            request()->file('logo')->storeAs('public/images', 'logo.' . request()->file('logo')->extension());

            $settings->school_logo = 'logo.' . request()->file('logo')->extension();


        } else {
            $settings->school_logo = $settings->getOriginal('logo');
        }

        $settings->update();

        return redirect()->route('settings')->with('message', 'Logo successfully updated.');


    }

    /**
     * Update / Post the front page contents
     */
    public function saveFrontPageCode ()
    {
        $settings = Settings::first();
        $settings->frontpage = request('frontpage');
        $settings->update();

        return redirect()->route('settings')->with('message', 'Front page contents were successfully uploaded.');
    }

    /**
     * Save a list of allowed domains
     */
    public function saveWhitelist(Request $request)
    {
        $request->validate([
            'whitelist' => 'required'
        ]);

        $whiteList = array_map( 'trim', explode( ', ' ,  $request->whitelist ) );

        foreach ($whiteList as $domain) {
            DB::insert('insert into whitelist (domain) values (?)', [$domain]);
        }

        return redirect()->route('settings')->with('message', 'Your whitelist was successfully updated.');
    }

    /**
     * Delete a whitelist element (domain)
     */
    public function deleteDomain($request)
    {
        DB::table('whitelist')->delete($request);

        return redirect()->route('settings')->with('message', 'Domain successfully removed from the whitelist.');
    }
}
