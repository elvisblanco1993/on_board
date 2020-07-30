<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Section;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    public function store()
    {
        $rightAnswer = null;
        $hasRightAnswer = false;

        // Validate the data
        request()->validate([
            'name' => 'required',
            'body' => ['required', 'max:525'],
            'option1' => 'required',
            'option2' => 'required'
        ]);

        // Make sure at least one of the aswers are marked as correct
        for ($i=1; $i <=4 ; $i++) {
            $rightAnswer = 'correct' . $i;

            if ( ! is_null( request( $rightAnswer ) ) ) {
                $hasRightAnswer = true;
            }
        }
        // Redirect back with error message if there are no right answers
        if ($hasRightAnswer === false) {
            return redirect('/section/create/' . request('orientation') . '?content-type=3')->with('errMessage', 'Please make sure you select at least one right answer.');
        }

        /**
         * Save the question to the database
         */
        $question = new Section;
        $question->name = $question->label = request('name');
        $question->body = request('body');
        $question->save();
        $question->types()->attach(request('type'));
        $question->orientation()->attach(request('orientation'));

        /**
         * Save the answers
         */
        for ($i = 1; $i <= 4; $i++) {
            if ( ! is_null( request('option' . $i) ) ) {

                $answer = new Answer;
                $answer->question_id = $question->id;
                $answer->answer = request('option' . $i);

                // Mark as correct answer if correct
                if ( ! is_null( request('correct' . $i) ) && request('correct' . $i) === 'on' ) {
                    $answer->is_correct = true;
                } else {
                    $answer->is_correct = false;
                }

                // Save the answer
                $answer->save();
            }
        }

        return redirect('/orientation/'. request('orientation'))->with('message', 'Section created!');
    }

    /**
     * Update the assessment question and answers
     */
    public function update(Section $section)
    {
        // Validate the data
        request()->validate([
            'name' => 'required',
            'body' => ['required', 'max:525'],
        ]);

        $section->label = $section->name = request('name');
        $section->body = request('body');

        $section->save();

        // Saving the answers
        $answers = DB::table('answers')->where('question_id', $section->id)->get();

        foreach ($answers as $answer) {
            $answer->answer = request('option' . $answer->id);

            if ( ! is_null( request('correct' . $answer->id) ) && request('correct' . $answer->id) === 'on' ) {
                $answer->is_correct = true;
            } else {
                $answer->is_correct = false;
            }

            DB::update('update answers set answer = ?, is_correct = ? where id = ?', [$answer->answer, $answer->is_correct, $answer->id]);
        }

        return redirect(route('dashboard'))->with('message', 'Section successfully updated!');
    }
}

