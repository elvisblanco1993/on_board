@extends('layouts.app')

@section('content')

    @forelse ($user->orientations as $orientation)
        {{-- Student Dashboard --}}
        <div
            class="container"
            {{-- Load background image loaded by administrator --}}
            style="background-image: url('storage/images/{{ $orientation->background }}'); background-size: cover; background-repeat: no-repeat;">

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

                    @if ($orientation->sections->first()->id !== $start_at)

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
    @empty
    <div class="container my-4">
        <div class="row">
            <div class="col-md-12">
                <h2>
                    Welcome, {{$user->name}}!
                </h2>
                <div class="card text-left">
                    <div class="card-body">
                    <h4 class="card-title">There is nothing pending at this time.</h4>
                    <p class="card-text">Please come back later.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforelse

@endsection
