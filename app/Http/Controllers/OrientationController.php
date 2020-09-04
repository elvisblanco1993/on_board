<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Exports\OrientationStatisticsExport;
use App\Mail\UserEnrolled;
use App\Mail\OrientationCompleted;
use App\User;
use App\Orientation;
use App\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class OrientationController extends Controller
{
    public function show(Orientation $orientation)
    {
        $role = User::find(Auth::user()->id)->getRoles();

        return view('dashboards.orientation', [
            'orientation' => $orientation,
            'role' => $role
        ]);
    }

    /**
     * Edit orientation
     */
    public function edit(Orientation $orientation)
    {
        $role = User::find(Auth::user()->id)->getRoles();
        $certificate = $orientation->certificate ?? null;

        // dd($certificate);

        return view('orientation.edit', [
            'orientation' => $orientation,
            'role' => $role,
            'certificate' => $certificate,
        ]);
    }

    /**
     * Update orientation details
     * @return redirect
     */
    public function update(Orientation $orientation)
    {
        $dataVerify = request()->validate([
            'name' => 'required',
            'description' => 'max:255',
            'lang' => 'required',
            'btn_primary' => 'required',
            'btn_secondary' => 'required',
            'nav_bg' => 'required',
            'textbox_bg' => 'required'
        ]);

        // Background manipulation
        $orientation->background = request('background');

        if ($orientation->background) {
            if ($orientation->background !== $orientation->getOriginal('background')) {
                // Delete old background and upload new one
                $original_background = $orientation->getOriginal('background');
                Storage::disk('public')->delete('images/' . $original_background);
            }

            request('background')->store('images', 'public');
            $background = request('background')->hashName();
        } else {
            $background = $orientation->getOriginal('background');
        }

        // Update orientation data
        $orientation->update([
            'name' => request('name'),
            'description' => request('description'),
            'lang' => request('lang'),
            'background' => $background,
            'btn_primary' => request('btn_primary'),
            'btn_secondary' => request('btn_secondary'),
            'nav_bg' => request('nav_bg'),
            'textbox_bg' => request('textbox_bg'),
        ]);

        return redirect(route('dashboard'))->with('message', 'Orientation successfully updated.');
    }

    public function store()
    {
        $orientation = new Orientation($this->validateOrientation());

        if (!is_null(request('description'))) {
            $orientation->description = request('description');
        }

        if (!is_null(request('lang'))) {
            $orientation->description = request('lang');
        }

        $orientation->save();

        return redirect(route('dashboard'))->with('message', 'Orientation ' . $orientation->name . ' was successfully created.');
    }

    /**
     * Mass enrollment
     */
    public function enroll(Orientation $orientation)
    {
        request()->validate(['enroll' => 'required']);

        $studentEmail = array();

        // Parse through each user id
        foreach (request('enroll') as $user) {
            $orientation->users()->sync($user, false);
            $studentEmail[] = User::find($user)->email;
        }

        // Notify students
        Mail::to( $studentEmail )->queue( new UserEnrolled($orientation->name) );


        // Return to the Dashboard
        return redirect(route('dashboard'))
            ->with('message', 'The selected students were successfully enrolled.');
    }

    /**
     * Student unenroll
     *
     */
    public function unenroll(Orientation $orientation, User $user)
    {
        $student = User::find($user)->first();
        $student->orientations()->detach($orientation);
        $student->sections()->detach();

        // Return to the statistics view
        return redirect('/orientation/' . $orientation->id . '/stats')->with('message', $student->name . ' was successfully unenrolled from the orientation.');

    }

    /**
     * Finish orientation
     */
    public function finish(Orientation $orientation, Section $section)
    {
        $user = User::find(Auth::user()->id);

        // Mark last section as completed
        $user->sections()->where('section_id', $section->id)->update([
            'completed_at' => now()
            ]);

        // Complete the orientation
        $user->orientations()->where('orientation_id', $orientation->id)->update( [
            'completed_at' => now()
        ]);

        Mail::to( $user->email )->queue( new OrientationCompleted($orientation->name) );

        return redirect(route('dashboard'))->with('message', 'Congratulations on finishing your Orientation!');
    }

    /**
     * Delete orientation
     */
    public function destroy(Orientation $orientation)
    {
        // Check that the Orientation doesn't have any sections.
        if ($orientation->sections->count() > 0) {
            return redirect(route('dashboard'))->with('errMessage', 'This orientation could not be deleted because it contains sections. Please delete all sections and try again.');
        }

        DB::table('orientations')->delete($orientation->id);

        return redirect(route('dashboard'))->with('message', 'Orientation deleted.');
    }

    /**
     * Verify input data
     */
    public function validateOrientation() {
        $validateOrientation = request()->validate([
            'name' => 'required',
        ]);

        return $validateOrientation;
    }

    /**
     * Orientation Player
     */
    public function player(Orientation $orientation, Section $section)
    {
        $user = User::find(Auth::user()->id);
        $role = $user->getRoles();

        // Assessment variables
        $possibleAnswers = DB::table('answers')->where('question_id', $section->id)->get()->shuffle() ?? null;



        // Sections variables

        $current = $next = $prev = null;

        if ( ! is_null ( $orientation->sections()->find($section->id) ) ) {
            $current = $section->id;
        }

        if ( ! is_null ( $orientation->sections()->find($section->where('id', '>', $section->id)->first()) ) ) {
            $next = $section->where('id', '>', $section->id)->first()->id;
        }

        if ( ! is_null ( $orientation->sections()->find($section->where('id', '<', $section->id)->orderBy('id','desc')->first()) ) ) {
            $prev = $section->where('id', '<', $section->id)->orderBy('id','desc')->first()->id;
        }


        // Sync the student with the sections beforehand
        $user->sections()->sync($orientation->sections, false);

        // Verify the orientation belongs to the user
        if ($user->orientations->find($orientation->id)->id == $orientation->id) {

            // Check sections status
            $completedAt = DB::table('section_user')->where('user_id', $user->id)->where('section_id', $current)->get()[0]->completed_at;

            /**
             * Check if the current section is not complete, and if a previous section exists on this orientation.
             * This helps identify whether this is the first slide or not
             **/
            if (is_null($completedAt) && $prev !== $current) {
                // Mark the previous section as complete.
                $user->sections()->where('section_id', $prev)->update(['completed_at' => now()]);
            }

            if (request()->method() == "GET") {

                $current = DB::table('section_user')->where('user_id', $user->id)->where('completed_at', null)->get()[0]->section_id;

                return redirect('/player/' . $orientation->id . '/continue/' . $current);
            }

            // Load view
            return view('student.myorientation.player', [
                        'orientation' => $orientation,
                        'section' => $section,
                        'role' => $role,
                        'current' => $current,
                        'prev' => $prev,
                        'next' => $next,
                        'possibleAnswers' => $possibleAnswers
                    ]);

        }
    }

    public function continue(Orientation $orientation, Section $section)
    {
        $user = User::find(Auth::user()->id);
        $role = $user->getRoles();


        $current = $section->id;
        $next = $section->where('id', '>', $current)->first()->id ?? $current;
        $prev = $section->where('id', '<', $current)->orderBy('id','desc')->first()->id ?? $current;

        // Load view
        return view('student.myorientation.continue', [
            'orientation' => $orientation,
            'section' => $section,
            'role' => $role,
            'current' => $current,
            'prev' => $prev,
            'next' => $next,
        ]);
    }

    /**
     * Orientation Statistics
     *
     * @return array
     */
    public function stats(Orientation $orientation)
    {
        $user = User::find(Auth::user()->id);
        $role = $user->getRoles();

        $students = $orientation->users;

        // Return view with data
        return view('orientation.stats', [
            'students' => $students,
            'role' => $role,
            'orientation' => $orientation,
        ]);
    }

    /**
     * Export orientation statistics
     *
     * @return .xlsx excel file
     */
    public function exportStatistics(Orientation $orientation)
    {
        return Excel::download(new OrientationStatisticsExport( $orientation->id ), 'orientation_statistics.xlsx');
    }
}
