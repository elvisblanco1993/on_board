<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\User;
use App\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    /**
     * Display all documents
     */
    public function index()
    {
        return view('documents.index', [
            'documents' => Document::all(),
            'role' => User::find(Auth::user()->id)->getRoles(),
        ]);
    }

    public function create()
    {
        return view('documents.create', [
            'role' => User::find(Auth::user()->id)->getRoles(),
        ]);
    }

    /**
     * Create a document
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:documents,id',
            'content' => 'required'
        ]);

        $name = $request->get('name');
        $content = $request->get('content');

        $document = new Document();
        $document->name = $name;
        $document->content = $content;

        $document->save();

        return redirect('/documents')->with('message', 'The document was successfully created.');
    }

    /**
     * View a document
     */
    public function view(Document $document)
    {
        $pdf = App::make('dompdf.wrapper');

        $pdf->loadHTML(
            $document->content
        );

        return $pdf->stream($document->name . '.pdf');
    }

    /**
     * Edit a document
     */
    public function edit(Document $document)
    {
        return view('documents.edit', [
            'document' => $document,
            'role' => User::find(Auth::user()->id)->getRoles(),
        ]);
    }

    /**
     * Update a document
     */
    public function update(Document $document)
    {
        request()->validate([
            'name' => 'required',
            'content' => 'required',
        ]);

        $document->name = request('name');
        $document->content = request('content');

        $document->update();

        return redirect('/documents')->with('message', 'The document was successfully updated');
    }

    /**
     * Delete a document
     */
    public function delete(Document $document)
    {
        // Check if there are any users associated with the document before deletion
        if ( count($document->users) === 0 ) {

            // Delete the document
            $document->delete();

            return redirect('/documents')->with('message', 'The document was successfully deleted.');

        } else {
            // Return with error
            return redirect('/documents')->with('errMessage', 'Error! We cannot delete this document. Make sure there are no students associated to this document and try again.');
        }
    }
}
