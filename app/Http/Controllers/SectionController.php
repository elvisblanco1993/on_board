<?php

namespace App\Http\Controllers;

use App\Orientation;
use App\Section;
use App\Type;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    //

    /**
     * Preview a section
     * @return view
     */
    public function show(Section $section)
    {
        $video = '';
        $role = User::find(Auth::user()->id)->getRoles();

        if (Storage::disk('public')->exists('/videos/' .$section->video)) {
            $video = $section->video;
        }

        return view('section.show', [
            'section' => $section,
            'video' => $video,
            'role' => $role
            ]);
    }

    /**
     * Show section create view
     * @return view
     */
    public function create($orientationid)
    {
        $orientation = Orientation::findOrFail($orientationid); // returns a 404 error if the orientation does not exist
        $section_types = Type::all();
        $role = User::find(Auth::user()->id)->getRoles();

        return view('section.create', [
            'user' => Auth::user(),
            'role' => $role,
            'orientation' => $orientation,
            'section_types' => $section_types
        ]);
    }

    /**
     * Create a new section
     * @return redirect
     */
    public function store()
    {

        $section = new Section($this->validateSection());

        $section->body = request('body');

        $section->save();

        // Attach the section type
        $section->types()->attach(request('type'));

        // Attach to the orientation
        $section->orientation()->attach(request('orientation'));

        return redirect('/orientation/'. request('orientation'))->with('message', 'Section successfully created.');
    }

    /**
     * Edit section
     */
    public function edit(Section $section)
    {
        $answers = DB::table('answers')->where('question_id', $section->id)->get() ?? null;
        $role = User::find(Auth::user()->id)->getRoles();
        return view('section.edit', [
            'section' => $section,
            'role' => $role,
            'answers' => $answers,
            ]);
    }

    /**
     * Update section
     */
    public function update(Section $section)
    {
        $this->validateEditions();

        $section->name = request('name');
        $section->video = request('video');
        $section->body = request('body');

        $section->update();

        $orientation = Orientation::find($section->orientation[0]->id);

        return redirect('/orientation/' . $orientation->id)->with('message', 'Section successfully updated.');
    }

    /**
     * Destroy a section.
     * Removes the section and all data belonging to it. id: videos
     */
    public function destroy(Section $section)
    {
        $orientation = Orientation::find($section->orientation[0]->id);

        // Check that the Orientation doesn't have any sections.
        if ($orientation->users->count() > 0) {
            return redirect('/orientation/' . $orientation->id)->with('errMessage', 'This section cannot be deleted because there are students currently enrolled.');
        }

        //  Delete record from DB
        DB::table('sections')->delete($section->id);

        return redirect('/orientation/' . $orientation->id)->with('message', 'Section deleted!');
    }

    /**
     * Verify input data
     */
    public function validateSection() {

        switch (request('type')) {
            case '1':
                $validateSection = request()->validate([
                    'name' => 'required',
                    'body' => 'required',
                ]);
                break;
            case '2':
                $validateSection = request()->validate([
                    'name' => 'required',
                    'provider' => 'required',
                    'video' => 'required|active_url',
                ]);
                break;
            case '3':
                $validateSection = request()->validate([
                    'name' => 'required',
                    'body' => 'required',
                ]);
                break;
            default:
                return redirect(route('dashboard'))->with('message', 'We could not verify this submission.');
                break;
        }
        return $validateSection;
    }

    /**
     * Verify input data when editing
     */
    public function validateEditions() {

        switch (request('type')) {
            case '1':
                $validateSection = request()->validate([
                    'name' => 'required',
                    'body' => 'required',
                ]);
                break;
            case '2':
                $validateSection = request()->validate([
                    'name' => 'required'
                ]);
                break;
            case '3':
                $validateSection = request()->validate([
                    'name' => 'required',
                    'body' => 'required',
                ]);
                break;
            default:
                return redirect(route('dashboard'))->with('message', 'We could not verify this submission.');
                break;
        }
        return $validateSection;
    }
}
