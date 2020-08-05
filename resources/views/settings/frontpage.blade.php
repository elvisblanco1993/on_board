@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row my-4 d-flex justify-content-center">

            @include('layouts.sidebar')

            <div class="col-md-10">

                <div class="card">

                    <div class="card-header d-flex justify-content-between">

                        <span class="lead">
                            Front Page
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

                                <form action="{{ url('settings') . '/store/frontpage' }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <textarea class="form-control {{ $errors->has('frontpage') ? 'is-invalid' : '' }}" name="frontpage" id="fpage" cols="30" rows="10" placeholder="Insert your html here..">{{ $settings->frontpage }}</textarea>
                                    </div>
                                    @error('frontpage')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

