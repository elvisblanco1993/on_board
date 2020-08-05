@extends('layouts.app')

@section('content')

    @if ($role->contains('admin') || $role->contains('advisor'))
    <div class="container-fluid">
        <div class="row my-4 d-flex justify-content-center"">

            @include('layouts.sidebar')

            <div class="col-md-10">

                <div class="card">
                    <div class="card-header">
                        <a href="{{ url('users') }}" class="mr-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        <span class="lead text-capitalize">
                            Invite users
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

                        <form action="{{ url('users') }}" method="post">

                            @csrf

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <input name="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Jane Doe">
                                        @error('name')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email">
                                        @error('email')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <div class="input-group">
                                            <select name="orientation" class="custom-select">
                                                <option value=""></option>
                                                <optgroup label="Select an orientation">
                                                    @foreach ($orientations as $orientation)
                                                        <option value="{{ $orientation->id }}">{{ $orientation->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="float-right">
                                    <a class="btn btn-light mr-2" href="{{route('users')}}">Discard</a>
                                    <button class="btn btn-primary shadow-sm" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
                                </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

    @endif

@endsection
