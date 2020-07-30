@extends('layouts.app')

@section('content')
    @if ($role->contains('admin') || $role->contains('advisor'))
        <div class="container">
            <div class="row my-4 d-flex justify-content-center"">

                @include('layouts.sidebar')

                <div class="col-md-10">

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

                    @include('users.partials.userslist')
                    @include('dashboards.include.modals')
                </div>
            </div>
        </div>
    @endif
@endsection
