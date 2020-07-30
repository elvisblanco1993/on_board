@component('mail::message')
## Dear student

You have been enrolled in the following orientation:

- {{ $orientationName }}

Please click the button below to get started.

@component('mail::button', ['url' => 'http://momo.local'])
Start Orientation
@endcomponent

Don't forget to contact your advisor once you complete the orientation.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
