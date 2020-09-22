@extends('layouts.app')
@section('content')
    <div class="container-xl">
        <div class="row my-4 d-flex justify-content-center">

            @include('layouts.sidebar')

            <div class="col-md-10">

                <div class="row">

                    <div class="col-md-6">

                        @include('settings.partials.company')

                    </div>

                    <div class="col-md-6">

                        @include('settings.partials.allowed-domains')

                    </div>

                </div>

                <div class="row my-4">

                    <div class="col-md-12">

                        @include('settings.partials.front-page')

                    </div>

                </div>

            </div>

            @include('layouts.alert')

        </div>
    </div>
@endsection
