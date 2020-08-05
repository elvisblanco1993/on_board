@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row my-4 d-flex justify-content-center">

            @include('layouts.sidebar')

            <div class="col-md-10">

                <div class="card">

                    <div class="card-header d-flex justify-content-between">

                        <span class="lead">
                            Settings
                        </span>

                    </div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                <strong>{{ session('message') }}</strong>
                            </div>
                        @endif
                        @if (session('errMessage'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ session('errMessage') }}</strong>
                            </div>
                        @endif

                        @error('logo')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                        @enderror

                        <div class="row">

                            <div class="col-md-12">

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
