@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row my-4">

            @include('layouts.sidebar')

            <div class="col-md-10">

                <div class="card">
                    <div class="card-header">
                        <a href="{{ url('dashboard') }}" class="mr-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        <span class="lead text-capitalize">
                            Edit orientation
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="/orientation/{{ $orientation->id }}/update" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="form-group">
                                    <label for="name" class="mb-0">Name</label>
                                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ $orientation->name ?? old('name') }}">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                        <label for="description" class="mb-0">Description</label>
                                        <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ $orientation->description ?? old('description') }}</textarea>
                                        <small class="text-muted">
                                            Max: 255 characters
                                        </small>
                                        @error('description')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lang" class="mb-0">Language</label>
                                    <input type="text" name="lang" id="lang" class="form-control {{ $errors->has('lang') ? 'is-invalid' : '' }} " value="{{ $orientation->lang ?? old('lang') }}">
                                    @error('lang')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="bg-img" class="mb-0">Background image</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input name="background" type="file" class="custom-file-input {{ $errors->has('background') ? 'is-invalid' : '' }}" id="img" accept=".png, .jpeg, .jpg">
                                            <label class="custom-file-label" for="img">Choose file</label>
                                        </div>
                                    </div>
                                    @error('background')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="btn-primary" class="mb-0">Primary button</label>
                                    <select name="btn_primary" id="btn-primary" class="custom-select {{ $errors->has('btn_primary') ? 'is-invalid' : '' }}">
                                        <optgroup label="Full color">
                                            <option {{ $orientation->btn_primary == 'btn-primary' ? 'selected' : '' }} value="btn-primary">Blue</option>
                                            <option {{ $orientation->btn_primary == 'btn-success' ? 'selected' : '' }} value="btn-success">Green</option>
                                            <option {{ $orientation->btn_primary == 'btn-warning' ? 'selected' : '' }} value="btn-warning">Yellow</option>
                                            <option {{ $orientation->btn_primary == 'btn-dark' ? 'selected' : '' }} value="btn-dark">Dark</option>
                                            <option {{ $orientation->btn_primary == 'btn-light' ? 'selected' : '' }} value="btn-light">Light</option>
                                        </optgroup>
                                        <optgroup label="Outlined">
                                            <option {{ $orientation->btn_primary == 'btn-outline-primary' ? 'selected' : '' }} value="btn-outline-primary">Outlined Blue</option>
                                            <option {{ $orientation->btn_primary == 'btn-outline-success' ? 'selected' : '' }} value="btn-outline-success">Outlined Green</option>
                                            <option {{ $orientation->btn_primary == 'btn-outline-warnin' ? 'selected' : '' }} value="btn-outline-warning">Outlined Yellow</option>
                                            <option {{ $orientation->btn_primary == 'btn-outline-dark' ? 'selected' : '' }} value="btn-outline-dark">Outlined Dark</option>
                                            <option {{ $orientation->btn_primary == 'btn-outline-light' ? 'selected' : '' }} value="btn-outline-light">Outlined Light</option>
                                        </optgroup>
                                    </select>
                                    @error('btn_primary')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="btn-secondary" class="mb-0">Secondary button</label>
                                    <select name="btn_secondary" id="btn-secondary" class="form-control custom-select {{ $errors->has('btn_secondary') ? 'is-invalid' : '' }}">
                                        <optgroup label="Full color">
                                            <option {{ $orientation->btn_secondary == 'btn-primary' ? 'selected' : '' }} value="btn-primary">Blue</option>
                                            <option {{ $orientation->btn_secondary == 'btn-success' ? 'selected' : '' }} value="btn-success">Green</option>
                                            <option {{ $orientation->btn_secondary == 'btn-warning' ? 'selected' : '' }} value="btn-warning">Yellow</option>
                                            <option {{ $orientation->btn_secondary == 'btn-dark' ? 'selected' : '' }} value="btn-dark">Dark</option>
                                            <option {{ $orientation->btn_secondary == 'btn-light' ? 'selected' : '' }} value="btn-light">Light</option>
                                        </optgroup>
                                        <optgroup label="Outlined">
                                            <option {{ $orientation->btn_secondary == 'btn-outline-primary' ? 'selected' : '' }} value="btn-outline-primary">Outlined Blue</option>
                                            <option {{ $orientation->btn_secondary == 'btn-outline-success' ? 'selected' : '' }} value="btn-outline-success">Outlined Green</option>
                                            <option {{ $orientation->btn_secondary == 'btn-outline-warning' ? 'selected' : '' }} value="btn-outline-warning">Outlined Yellow</option>
                                            <option {{ $orientation->btn_secondary == 'btn-outline-dark' ? 'selected' : '' }} value="btn-outline-dark">Outlined Dark</option>
                                            <option {{ $orientation->btn_secondary == 'btn-outline-light' ? 'selected' : '' }} value="btn-outline-light">Outlined Light</option>
                                        </optgroup>
                                    </select>
                                    @error('btn_secondary')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nav-bg" class="mb-0">Navigation bar background</label>
                                    <select name="nav_bg" id="nav-bg" class="custom-select {{ $errors->has('nav_bg') ? 'is-invalid' : '' }}">
                                        <option {{ $orientation->nav_bg == 'bg-primary' ? 'selected' : '' }} value="bg-primary">Blue</option>
                                        <option {{ $orientation->nav_bg == 'bg-success' ? 'selected' : '' }} value="bg-success">Green</option>
                                        <option {{ $orientation->nav_bg == 'bg-warning' ? 'selected' : '' }} value="bg-warning">Yellow</option>
                                        <option {{ $orientation->nav_bg == 'bg-dark' ? 'selected' : '' }} value="bg-dark">Dark</option>
                                        <option {{ $orientation->nav_bg == 'bg-light' ? 'selected' : '' }} value="bg-light">Light</option>
                                        <option {{ $orientation->nav_bg == 'bg-white' ? 'selected' : '' }} value="bg-white">White</option>
                                    </select>
                                    @error('nav_bg')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="tbbg">Textbox background</label>
                                    <input
                                        type="text"
                                        name="textbox_bg"
                                        id="tbbg"
                                        class="form-control {{ $errors->has('textbox_bg') ? 'is-invalid' : '' }}"
                                        placeholder="rgba(198, 215, 219, 0.61)"
                                        value="{{ $orientation->textbox_bg ?? '' }}">

                                    @error('textbox_bg')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            <div class="form-group float-right">
                                <a href="{{ url()->previous() }}" class="btn btn-light mr-2">Dismiss</a>
                                <input class="btn btn-success shadow-sm" type="submit" value="Save details">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
