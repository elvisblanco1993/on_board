<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Document;
use App\Orientation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Crypt;

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
            'orientations' => Orientation::all(),
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

        TCPDF::setFooterCallback(function($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // Page number
            $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });

        $documentName = $document->name;

        TCPDF::SetTitle($document->name);
        TCPDF::SetSubject($document->name);
        TCPDF::SetFontSubsetting(false);
        TCPDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        TCPDF::AddPage();
        TCPDF::writeHTML($document->content, true, 0, true, 0);
        TCPDF::lastPage();
        TCPDF::Output($documentName . '.pdf', 'I');
        TCPDF::reset();
    }

        /**
     * View a document
     */
    public function viewSigned(Document $document, User $user)
    {

        TCPDF::setFooterCallback(function($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // Page number
            $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });

        $documentName = $document->name;
        $signedAt = DB::table('document_user')->where('document_id', $document->id)->where('user_id', $user->id)->get()[0]->signed_at;

        $certificate = 'file://' . base_path() . config('services.pdf.certificate') ?? null;

        /**
         * Sign document if a certificate is present.
         */
        if ( file_exists($certificate) ) {
            // set additional information
            $info = array(
                'Name' => $user->name,
                'Location' => config('app.name'),
                'Reason' => 'Agreed with ' . $document->name,
                'ContactInfo' => config('app.url'),
                );
            TCPDF::setSignature($certificate, $certificate, config('app.name'), '', 2, $info);
        }
        // End of document signature


        $encryptedDocumentCode = Crypt::encryptString($documentName . $user->name . $signedAt);

        $readableSignedDate = date('F j, Y g:i:s a', strtotime($signedAt));

        $signature = "<div style=\"font-size: 10pt\">
                        <hr>
                        <p>Signature: <u style=\"color: darkblue\"><i>$user->name</i></u></p>
                        <p>Date: <u style=\"color: darkblue\"><i>$readableSignedDate</i></u></p>
                        <p><span style=\"color: red; font-size: 6pt\">$encryptedDocumentCode</span></p>
                      </div>";

        TCPDF::SetTitle($document->name);
        TCPDF::SetSubject($document->name);
        TCPDF::SetCreator(config('app.name'));
        TCPDF::SetAuthor(config('app.name'));
        TCPDF::SetFontSubsetting(false);
        TCPDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        TCPDF::AddPage();
        TCPDF::writeHTML($document->content, true, 0, true, 0);
        TCPDF::writeHTML($signature, true, false, true, false, '');
        TCPDF::lastPage();
        TCPDF::Output($documentName . '.pdf', 'I');
        TCPDF::reset();
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

        return redirect('/documents')->with('message', 'The document was successfully updated.');
    }

    /**
     * Attach a document to one or more orientations
     */
    public function attachToOrientation(Document $document)
    {
        request()->validate([
            'orientation' => 'required|array',
        ]);

        foreach ( request('orientation') as $orientation ) {
            $document->orientations()->attach($orientation);
        }

        return redirect('/documents')->with('message', 'The document was successfully attached to the selected orientations.');
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

    /**
     * Sign a document
     */
    public function sign(Document $document)
    {
        request()->validate([
            'user' => 'required|exists:users,id'
        ]);

        $user = User::find(Auth::user(request('user'))->id);
        $signedStatus = DB::table('document_user')->where('document_id', $document->id)->where('user_id', $user->id)->get()[0]->signed_at;

        if ( is_null( $signedStatus ) ) {

            $user->documents()->where('document_id', $document->id)->where('user_id', $user->id)->update([ 'signed_at' => now() ]);
            return redirect('/dashboard')->with('message', 'Document signed.');

        } else {

            return redirect('/dashboard')->with('errMessage', 'This document is already signed and cannot be signed again.');

        }
    }

    public function getSignedDocument(Document $document)
    {
        //
    }
}
