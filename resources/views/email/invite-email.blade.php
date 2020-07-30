@component('mail::message')
## Dear {{ $name }}

You have been invited to join {{ config('app.name') }} platform.

Please click the button below to get started.

@component('mail::button', ['url' => $url ])
Sign Up
@endcomponent

If you present any complications while signing up, please contact your administrator or advisor.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
