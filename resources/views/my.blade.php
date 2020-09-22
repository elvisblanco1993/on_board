@extends('layouts.app')

@section('content')

    <div class="container-xl">
        <div class="row my-4">

            @include('layouts.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url('dashboard') }}">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        @error('avatar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @if ( session('message') )
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <div class="d-flex justify-content-center">
                            <div class="media">
                                <a class="mr-3" type="button" data-toggle="modal" data-target="#updateAvatar">
                                    <img class="avatar rounded" src="{{ url('storage/images/' . $user->avatar) }}" alt="{{ config('app.name') }}" height="128" width="128">
                                </a>
                                <div class="media-body">
                                    <p class="lead">{{ $user->name }}</p>
                                    <p>{{ $user->email }}</p>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#chPassword"><i class="fa fa-key" aria-hidden="true"></i> Reset password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Update avatar --}}
    <div class="modal fade" id="updateAvatar" tabindex="-1" role="dialog" aria-labelledby="updateAvatarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAvatarLabel">Update avatar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/my/update" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input"
                                        id="updateAvatarField"
                                        aria-describedby="updateAvatarFileLabel"
                                        name="avatar"
                                        accept=".png,.jpeg,.jpg">
                                    <label class="custom-file-label" for="updateAvatarField">Choose avatar</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit" id="updateAvatarFileLabel">
                                        <i class="fas fa-upload"></i>
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>

    {{-- Password reset --}}
    <div class="modal fade" id="chPassword" tabindex="-1" role="dialog" aria-labelledby="chPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chPasswordLabel">Reset password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/my/updatePassword') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="password">New password</label>
                            <input id="password" type="password" class="form-control" name="password" required="" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirm password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required="" autocomplete="new-password">
                        </div>
                        <div class="form-group float-right">
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="fa fa-key" aria-hidden="true"></i>
                                Reset password
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
      </div>

@endsection
