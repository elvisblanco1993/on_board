@extends('layouts.app')

@section('content')
    @if ($role->contains('admin') || $role->contains('advisor'))
        <div class="container-xl">
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

                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <span class="mb-0 pb-0">
                                <a href="{{ url('users') }}" class="mr-3">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <span class="lead text-capitalize">
                                    Back
                                </span>
                            </span>
                            <a role="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#editUser{{ $user->id }}">
                                <i class="fas fa-user-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="container-xl">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-4">
                                            <div class="media">
                                                @if ( $user->avatar )

                                                    <img
                                                    src="{{ url('/storage/images/' . $user->avatar) }}"
                                                    alt="{{$user->name}}"
                                                    class="avatar rounded-circle mr-3"
                                                    width="128"
                                                    height="128">

                                                @endif

                                                <div class="media-body align-self-center">
                                                    <h4>{{$user->name}}</h4>
                                                    <p class="mb-0"><i class="fas fa-envelope text-secondary mr-2"></i> {{$user->email}}</p>
                                                    <p class="text-capitalize mb-0">
                                                        <i class="fas fa-user-tag text-secondary mr-2"></i>{{$user->roles[0]->label}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- User is a Student --}}
                            @if ($user->roles[0]->id == 3)
                                <div class="container-xl">
                                    <div class="row">
                                        <div class="col">
                                            {{-- Orientations --}}
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="text-capitalize mb-3">
                                                        <i class="fas fa-play-circle mr-1 text-secondary"></i>
                                                        Orientations
                                                    </h5>
                                                    <ul class="list-group">

                                                        @if ( count($orientations) > 0 )
                                                            @foreach ($orientations as $orientation)
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    {{$orientation->name}}

                                                                    @if ( ! is_null( $orientation->pivot->completed_at ) )
                                                                        <span class="bg-success p-1 rounded-lg">
                                                                            <i class="fas fa-check-circle"></i>
                                                                            Completed on:
                                                                            {{ date('M d, Y', strtotime($orientation->pivot->completed_at)) }}
                                                                        </span>
                                                                    @else
                                                                        <i class="fas fa-spinner fa-pulse" title="Orientation still in progress or not started."></i>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        @endif

                                                    </ul>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Edit user --}}
        <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="editUser">Editing: {{ $user->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="/user/{{ $user->id }}/update" method="POST">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                              <label for="name">Name</label>
                              <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                placeholder="John Smith"
                                value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="roles">Role</label>
                                <select name="role" class="form-control custom-select text-capitalize">
                                    @foreach ($appRoles as $appRole)
                                    <option
                                        class="text-capitalize"
                                        value="{{ $appRole->id }}"
                                        @if ( !empty($user->roles[0]->id) )
                                            @if ($user->roles[0]->id == $appRole->id)
                                                selected
                                            @endif
                                        @endif
                                        >{{ $appRole->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
