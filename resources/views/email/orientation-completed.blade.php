@component('mail::message')
# Congratulations!

You have successfully completed the following orientation:

- {{ $orientationName }}

Please notify your advisor for instructions and next steps.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
