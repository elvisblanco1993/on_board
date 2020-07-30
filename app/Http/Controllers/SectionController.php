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

        // Store the video
        if ($section->video) {
            $section->video->store('videos', 'public');
            $section->video = $section->video->hashName();
            $section->body = request('body');
        }

        $section->save();

        // Attach the section type
        $section->types()->attach(request('type'));

        // Attach to the orientation
        $section->orientation()->attach(request('orientation'));

        return redirect('/orientation/'. request('orientation'))->with('message', 'Section created!');
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

        if ($section->video) {
            if ($section->video !== $section->getOriginal('video')) {
                // Delete old video and upload new one
                $original_video = $section->getOriginal('video');
                Storage::disk('public')->delete('videos/' . $original_video);
            }

            $section->video->store('videos', 'public');
            $section->video = $section->video->hashName();
        } else {
            $section->video = $section->getOriginal('video');
        }

        $section->update();

        return redirect(route('dashboard'))->with('message', 'Section successfully updated!');
    }

    /**
     * Destroy a section.
     * Removes the section and all data belonging to it. id: videos
     */
    public function destroy(Section $section)
    {
        $orientation = $section->orientation[0]->id;

        //  Delete video file if applicable
        if ($section->video) {
            Storage::disk('public')->delete('videos/' . $section->video);
        }

        //  Delete record from DB
        DB::table('sections')->delete($section->id);

        return redirect('/orientation/' . $orientation)->with('message', 'Section deleted!');
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
                    'video' => 'required|mimes:m4v,mp4,webm',
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
