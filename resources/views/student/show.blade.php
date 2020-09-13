@extends('layouts.app')

@section('content')

        <style>
            body{
                background-image: url('/storage/images/{{ $orientation->background }}');
                background-size: cover;
                background-repeat: no-repeat;
            }
        </style>

        {{-- Student Dashboard --}}
        <div
            class="container"
        >
            <div class="row align-items-center d-flex justify-content-center m-0" style="height:100vh">
                <div class="col-md-5 text-right">
                    <img class="img-responsive"
                        src="{{ url('/storage/images/logo.png') }}"
                        alt="{{ $orientation->name }}"
                        width="60%">
                </div>
                <div class="col-md-5 p-4 rounded-lg" style="background: {{ $orientation->textbox_bg }}">
                    <h1 class="font-weight-bolder">
                        {{ $orientation->name }}
                    </h1>

                    <p class="lead">
                        {{ $orientation->description }}
                    </p>

                    @if ($orientation->sections->first()->id !== (integer)$start_at)

                        <form action="/player/{{ $orientation->id }}/section/{{ $start_at }}" method="post">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-lg {{ $orientation->btn_primary ?? 'btn-primary' }}" type="submit">Continue</button>
                        </form>

                    @else

                        <form action="/player/{{ $orientation->id }}/section/{{ $orientation->sections->first()->id }}" method="post">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-lg {{ $orientation->btn_primary ?? 'btn-primary' }}" type="submit">Start orientation</button>
                        </form>

                    @endif

                </div>
            </div>
        </div>
@endsection
