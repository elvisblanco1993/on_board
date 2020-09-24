@extends('layouts.app')
@section('content')
    @if ($role->contains('admin'))
        <div class="container-xl">
            <div class="row my-4 d-flex justify-content-center">

                @include('layouts.sidebar')

                <div class="col-md-10">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <span class="lead text-capitalize">
                                orientations
                            </span>
                            <a  type="button"
                                class="text-primary mb-0"
                                data-toggle="modal"
                                data-target="#new_orientation">
                                <i class="fas fa-plus-circle mr-1"></i>New
                            </a>
                        </div>
                        <div class="card-body">

                            @include('dashboards.include.orientations')

                        </div>
                    </div>

                    @include('dashboards.include.modals')
                </div>

                @include('layouts.alert')

            </div>
        </div>
    @endif
@endsection
