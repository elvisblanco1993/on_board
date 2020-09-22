@extends('layouts.app')
@section('content')

<style>
    body{
        background-image: url('/storage/images/{{ $orientationBg }}');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>
<div class="container-xl">
    <div class="row my-4 d-flex justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <img src="{{ url('/storage/images/logo.png') }}" alt="{{ config('app.name') }}" class="align-self-center mr-3" style="max-width: 20%">
                    <div class="media-body align-self-center">
                        <h1 class="media-heading">Congratulations!</h1>
                        <p class="lead">
                            You have successfully completed the <strong>{{ $orientationName }}</strong> orientation.
                        </p>
                        <p>You will receive a confirmation email as well. Please contact your advisor to register for classes.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
