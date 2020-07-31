@extends('layouts.app')
@section('content')
    @if ($role->contains('advisor'))
        <div class="container">
            <div class="row my-4 ">

                @include('layouts.sidebar')

                <div class="col-md-10">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <span>
                                Orientations
                            </span>
                        </div>
                        <div class="card-body">

                            @if (session('message'))
                                <div class="alert alert-success" role="alert">
                                    <strong>{{ session('message') }}</strong>
                                </div>
                            @endif
                            @if (session('errMessage'))
                                <div class="alert alert-warning" role="alert">
                                    <strong>{{ session('errMessage') }}</strong>
                                </div>
                            @endif

                            @include('dashboards.include.orientations')
                        </div>
                    </div>
                    @include('dashboards.include.modals')
                </div>
            </div>
        </div>
    @endif
@endsection
