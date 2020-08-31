<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $certificate->id }}</title>

    <style>
        @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }

        body {
            background-color: {{ $certificate->body_bg ?? '#ffffff' }};
        }

        .certificate {
            background-color: {{ $certificate->cert_bg }};
            text-align: center;
            color: {{ $certificate->cert_text_color ?? '#000000' }};
            margin: 80px 60px 0 60px !important;
            padding: 5px;
            font-size: 1.4rem;
            border-width:  {{ $certificate->cert_border_out_thickness ?? '0px' }};
            border-style: {{ $certificate->cert_border_out_style ?? 'solid' }};
            border-color:  {{ $certificate->cert_border_out_color ?? 'none'}};
            border-radius: {{ $certificate->cert_border_out_radius ?? '0px' }};
        }

        .certificate-interior {
            padding: 100px;
            border-width: {{ $certificate->cert_border_in_thickness ?? '0px' }};
            border-style: {{ $certificate->cert_border_in_style ?? 'solid' }};
            border-color: {{ $certificate->cert_border_in_color ?? 'none'}};
            border-radius: {{ $certificate->cert_border_in_radius ?? '0px' }};
        }

        #title {
            /*  */
        }

        .inter {
            margin-top: 20px !important;
        }

        #certifies, {
            font-size: 1.6rem;
            margin-top: 20px !important;
        }

        #name {
            margin-top: 40px !important;
        }

        #completed, #course {
            margin-top: 40px !important;
        }

        .cert-data {
            position: absolute;
            bottom: 0;
            margin-bottom: 10px;
            text-align: center;
            color: {{ $certificate->footer_text_color ?? '#000000' }};
        }



    </style>

</head>
<body>
    <div class="certificate">
        <div class="certificate-interior">
            <h1 id="title">CERTIFICATE OF COMPLETION</h1>
            <div class="inter">***********************************************</div>
            <h3 id="certifies">THIS AWARD CERTIFIES THAT</h3>
            <h2 id="name"><u>{{ 'Elvis Blanco' }}</u></h2>
            <h3 id="completed">HAS SUCCESSFULLY COMPLETED</h3>
            <h2 id="course"><u>{{ 'Course Name' }}</u></h2>
        </div>
    </div>
    <div class="cert-data">
        <p>Certificate ID: 1234321 / Completed on: September 10, 2020</p>
    </div>
</body>
</html>
