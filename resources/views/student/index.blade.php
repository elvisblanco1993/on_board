@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h4>
                Orientations
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 m-0">
            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-info" role="alert">
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif
            @if (session('errMessage'))
                <div class="alert alert-warning" role="alert">
                    <strong>{{ session('errMessage') }}</strong>
                </div>
            @endif
        </div>
    </div>

    <div class="row d-flex justify-content-center">

        @isset($orientations)

            @foreach ($orientations  as $orientation)

                @isset($orientation->users->first()->pivot->completed_at)
                    <div class="col-md-3">

                        <div class="card p-0">
                            <span
                                style="height: 5rem; background-color: {{ $cardBg }}; border-radius: .6rem .6rem 0 0">
                            </span>
                            <div class="card-body">
                                <h5 class="card-title">{{ $orientation->name }}</h5>
                                <p class="card-text">
                                    <span class="badge badge-success">
                                        <span class="font-weight-bolder">Completed on</span> {{ $orientation->users->first()->pivot->completed_at }}
                                    </span>
                                </p>
                                <a href="{{ url('/player/' . $orientation->id) }}" class="btn btn-sm btn-primary">Open</a>
                            </div>
                        </div>

                    </div>
                @else

                    <div class="col-md-3">

                        <div class="card p-0">
                            <span
                                style="height: 5rem; background-color: {{ $cardBg }}; border-radius: .6rem .6rem 0 0">
                            </span>
                            <div class="card-body">
                                <h5 class="card-title">{{ $orientation->name }}</h5>
                                <p class="card-text text-truncate">{{ $orientation->description }}</p>
                                <a href="{{ url('/player/' . $orientation->id) }}" class="btn btn-sm btn-primary">START ORIENTATION</a>
                            </div>
                        </div>

                    </div>

                @endisset

            @endforeach

        @endisset

    </div>


    {{-- Show Documents --}}
    @if ( count( $documents ) > 0 )
    <div class="row mt-5">
        <div class="col-md-12">
            <h4>
                Documents
            </h4>
        </div>
        @include('student.documents.index')
    </div>
    @endif

</div>
@endsection
