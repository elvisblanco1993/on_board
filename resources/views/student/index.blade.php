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

    <div class="row d-flex">

            @forelse ($orientations  as $orientation)

                @isset($orientation->users->find($user->id)->pivot->completed_at)
                    <div class="col-md-3">

                        <div class="card p-0 my-2">
                            <span
                                class="rounded-top nb-course-card-graph"
                                style="@if( ! is_null ($orientation->background) ) background-image: url('/storage/images/{{ $orientation->background }}'); background-size: cover; background-repeat: no-repeat;] @else background: #5fdbba @endif"
                            >

                            </span>
                            <div class="card-body">
                                <h5 class="card-title">{{ $orientation->name }}</h5>
                                <p class="card-text">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Completed:
                                    {{ date('M d, Y', strtotime($orientation->users->first()->pivot->completed_at)) }}
                                </p>
                                {{-- Download Certificate --}}
                                @if ( count($orientation->certificate) === 1)
                                    @if ( $orientation->certificate->first()->status === 'on' )
                                        <form action="{{ url('/certificate/' . $orientation->certificate->first()->id . '/download') }}" method="GET">
                                            @csrf
                                            <button class="btn btn-lg btn-link p-0" title="Download certificate of completion.">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="#5a67d8">
                                                    <path d="M10 8h-5v-1h5v1zm0 1h-5v1h5v-1zm0 2h-5v1h5v-1zm-2 2h-3v1h3v-1zm10.692-3.939c-.628-.436-.544-.327-.782-1.034-.099-.295-.384-.496-.705-.496h-.003c-.773.003-.64.044-1.265-.394-.129-.092-.283-.137-.437-.137s-.308.045-.438.137c-.629.442-.492.397-1.265.394h-.003c-.321 0-.606.201-.705.496-.238.71-.156.6-.781 1.034-.198.137-.308.353-.308.578l.037.222c.242.708.242.572 0 1.278l-.037.222c0 .224.11.441.309.578.625.434.545.325.781 1.033.099.296.384.495.705.495h.003c.773-.003.64-.044 1.265.394.129.093.283.139.437.139s.308-.046.438-.138c.625-.438.49-.397 1.265-.394h.003c.321 0 .606-.199.705-.495.238-.708.154-.599.782-1.033.197-.137.307-.355.307-.579l-.037-.222c-.242-.709-.24-.573 0-1.278l.037-.222c0-.225-.11-.443-.308-.578zm-3.192 3.189c-.967 0-1.75-.784-1.75-1.75 0-.967.783-1.751 1.75-1.751s1.75.784 1.75 1.751c0 .966-.783 1.75-1.75 1.75zm1.241 2.758l.021-.008h1.238v7l-2.479-1.499-2.521 1.499v-7h1.231c.415.291.69.5 1.269.5.484 0 .931-.203 1.241-.492zm-16.741-13.008v17h11v-2h-9v-13h20v13h-2v2h4v-17h-24z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>

                    </div>
                @else

                    <div class="col-md-3">

                        <div class="card p-0 my-2">
                            <span class="rounded-top nb-course-card-graph"
                                style="@if( ! is_null ($orientation->background) ) background-image: url('/storage/images/{{ $orientation->background }}'); background-size: cover; background-repeat: no-repeat;] @else background: #5fdbba @endif"
                            >
                            </span>
                            <div class="card-body">
                                <h5 class="card-title">{{ $orientation->name }}</h5>
                                <a
                                    @if ( count($orientation->sections) > 0 )
                                        class="btn btn-sm btn-primary"
                                        href="{{ url('/player/' . $orientation->id) }}"
                                    @else
                                        class="btn btn-sm btn-primary disabled"
                                    @endif
                                >START ORIENTATION</a>
                            </div>
                        </div>

                    </div>

                @endisset

            @empty

            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle mr-2"></i>
                    You are currently not enrolled in any orientations. Please contact your advisor for further details.
                </div>
            </div>

            @endforelse

    </div>

</div>
@endsection
