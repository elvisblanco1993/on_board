@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row">

        {{-- No orientations have been assigned --}}
        @if ( $user->orientations->count() === 0 )

            <div class="card w-100">
                <div class="card-body text-center py-5">
                    <h4>Hey there!</h4>
                    <p class="lead">
                        We are glad you could make it here. <br>It seems there are no orientations assigned to you at this time. Please contact your advisor for more details.
                    </p>
                </div>
            </div>

            @include('student.documents.index')

        @endif

        {{-- An orientation was assigned, but is empty --}}
        @isset($hasSections)
            @if ($hasSections === false)
                <div class="card w-100">
                    <div class="card-body">
                        <h1>Something went wrong...</h1>
                        <p class="lead">It seems we are having trouble getting your orientation started.</p>
                        <p>Please contact your advisor with the error code: <code>nosectionsfound</code></p>
                    </div>
                </div>
            @endif
        @endisset

        @isset($orientations)
            <div class="card w-100">
                <div class="card-header">
                    <h4 class="mb-0">
                        Completed orientations
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($orientations  as $orientation)

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $orientation->name }}
                                <span class="badge badge-success">
                                    <span class="font-weight-bolder">Completed on</span> {{ $orientation->users->first()->pivot->completed_at }}
                                </span>
                            </li>

                        @endforeach
                    </ul>
                </div>
            </div>
        @endisset
    </div>
</div>
@endsection
