@extends('layouts.app')
@section('content')
    <div class="container">
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

                            <div class="col-md-2">

                                <ul class="nav flex-column nav-pills nav-fill" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="true">Institution</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-fpage-tab" data-toggle="pill" href="#pills-fpage" role="tab" aria-controls="pills-fpage" aria-selected="false">Front Page</a>
                                    </li>
                                </ul>

                            </div>

                            <div class="col-md-10">

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
                                        @include('settings.partials.__company-info')
                                    </div>
                                    <div class="tab-pane fade" id="pills-fpage" role="tabpanel" aria-labelledby="pills-fpage-tab">
                                        @include('settings.partials.__front-page')
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- Upload logo --}}
    <div class="modal fade" id="uploadLogo" tabindex="-1" role="dialog" aria-labelledby="uploadLogoLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="uploadLogoLabel">Upload logo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ url('settings') . '/store/logo' }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file"
                                class="custom-file-input"
                                id="newLogo"
                                aria-describedby="newLogoLabel"
                                name="logo"
                                accept=".png">
                            <label class="custom-file-label" for="newLogo">Choose logo</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="submit" id="newLogoLabel">
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
@endsection
