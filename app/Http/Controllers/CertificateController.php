<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Orientation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;

class CertificateController extends Controller
{
    /**
     * Create certificate
     */
    public function store(Orientation $orientation, Request $request)
    {
        $certificateId = $request->get('certid') ?? null;
        $orientation_id = $orientation->id;
        $status = $request->get('status');
        $paperOrientation = $request->get('po') ?? 'landscape';

        $body_bg = $request->get('body_bg');
        $cert_bg = $request->get('cert_bg');

        $cert_border_out_color = $request->get('cert_border_out_color');
        $cert_border_out_radius = $request->get('cert_border_out_radius');
        $cert_border_out_thickness = $request->get('cert_border_out_thickness');
        $cert_border_out_style = $request->get('cert_border_out_style');


        $cert_border_in_color = $request->get('cert_border_in_color');
        $cert_border_in_radius = $request->get('cert_border_in_radius');
        $cert_border_in_thickness = $request->get('cert_border_in_thickness');
        $cert_border_in_style = $request->get('cert_border_in_style');


        $cert_text_color = $request->get('cert_text_color');
        $footer_text_color = $request->get('footer_text_color');

        // Save a new certificate
        if ( ! isset( $certificateId ) ) {
            $cert = new Certificate();

            $cert->status = $status;
            $cert->paper_orientation = $paperOrientation;
            $cert->body_bg = $body_bg;
            $cert->cert_bg = $cert_bg;
            $cert->cert_border_out_color = $cert_border_out_color;
            $cert->cert_border_out_radius = $cert_border_out_radius;
            $cert->cert_border_out_thickness = $cert_border_out_thickness;
            $cert->cert_border_out_style = $cert_border_out_style;
            $cert->cert_border_in_color = $cert_border_in_color;
            $cert->cert_border_in_radius = $cert_border_in_radius;
            $cert->cert_border_in_thickness = $cert_border_in_thickness;
            $cert->cert_border_in_style = $cert_border_in_style;
            $cert->cert_text_color = $cert_text_color;
            $cert->footer_text_color = $footer_text_color;
            $cert->save();

            $cert->orientation()->attach($orientation_id);

            return redirect(route('dashboard'))->with('message', 'Certificate successfully created.');
        }


        // Update the selected certificate
        else {
            $cert = Certificate::find($certificateId);

            $cert->update([
                'status' => $status,
                'paper_orientation' => $paperOrientation,
                'body_bg' => $body_bg,
                'cert_bg' => $cert_bg,
                'cert_border_out_color' => $cert_border_out_color,
                'cert_border_out_radius' => $cert_border_out_radius,
                'cert_border_out_thickness' => $cert_border_out_thickness,
                'cert_border_out_style' => $cert_border_out_style,

                'cert_border_in_color' => $cert_border_in_color,
                'cert_border_in_radius' => $cert_border_in_radius,
                'cert_border_in_thickness' => $cert_border_in_thickness,
                'cert_border_in_style' => $cert_border_in_style,

                'cert_text_color' => $cert_text_color,
                'footer_text_color' => $footer_text_color
            ]);

            return redirect(route('dashboard'))->with('message', 'Certificate successfully updated.');
        }
    }

    /**
     * Show certificate
     */
    public function show(Certificate $certificate)
    {
        $certificate = Certificate::find($certificate->id);
        $pdf = PDF::loadView('documents.certificate', compact('certificate'))
            ->setPaper('letter', "$certificate->paper_orientation")
            ->setOptions(['debugLayoutLines' => true]);
        return $pdf->stream();
    }

    /**
     * Update certificate
     */
    public function generate(Certificate $certificate)
    {
        $orientation = $certificate->orientation->first();

        $user = User::find(Auth::user()->id);

        $pdf = PDF::loadView('documents.certificate', compact(['certificate', 'orientation', 'user']))
            ->setPaper('letter', "$certificate->paper_orientation")
            ->setOptions(['debugLayoutLines' => true]);
        return $pdf->download();

    }
}
