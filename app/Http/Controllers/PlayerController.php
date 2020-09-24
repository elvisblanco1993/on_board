<?php

namespace App\Http\Controllers;

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


class PlayerController extends Controller
{
    public function index (Orientation $orientation)
    {
        $user = User::find(Auth::user()->id);
        $role = $user->getRoles();
        $first = DB::table('section_user')->where('user_id', $user->id)->first();

        // Has Orientation?
        if ( !empty( $orientation ) ) {
            // Sync the sections to the current user
            $tempUsr = User::find(Auth::user()->id);
            $toSync = $orientation->sections;

            $tempUsr->sections()->sync($toSync, false);


            // Let's re-check for sections now
            $first = DB::table('section_user')->where('user_id', $user->id)->first();

            $start_at = DB::table('section_user')->where('user_id', $user->id)->where('completed_at', null)->first();

            // Has sections assigned?
            if ( !empty( $orientation->sections->toArray() ) ) {

                // Check if there are sections completed

                if (is_null($start_at)) {

                    return view('student.myorientation.done', [
                        'user' => $user,
                        'role' => $role,
                        'completed' => true,
                        'orientationName' => $orientation->name,
                        'orientationBg' => $orientation->background,
                    ]);

                }
                else {
                    // Check if the student already made progress on the orientation.
                    if ($first->section_id == $start_at->section_id) {

                        // Start at the first section
                        return view('student.show', [
                            'user' => $user,
                            'role' => $role,
                            'start_at' => $first->section_id,
                            'orientation' => $orientation,
                        ]);

                    } else {
                        // Otherwise start at the start_at slide
                        return view('student.show', [
                            'user' => $user,
                            'role' => $role,
                            'start_at' => $start_at->section_id,
                            'orientation' => $orientation,
                        ]);
                    }
                }

            }
            else {
                /**
                 * If the orientation has content, redirect to the orientation
                 */
                if ( !is_null( $first ) && count( $orientation->sections ) > 0 ) {

                    return view('student.show', [
                        'user' => $user,
                        'role' => $role,
                        'start_at' => $first->section_id,
                        'orientation' => $orientation,
                    ]);

                } else {
                    return redirect('/dashboard')->with('info', $orientation->name .' is still being prepared. We will let you know when is ready.');
                }
            }

            return view('student.index', [
                'user' => $user,
                'role' => $role,
                'completed' => false,
            ]);

        } else {
            return view('student.index', [
                'user' => $user,
                'role' => $role,
                'completed' => false,
            ]);
        }
    }
}
