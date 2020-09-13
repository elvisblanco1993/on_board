@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row my-4">

            @include('layouts.sidebar')

            <div class="col-md-6">

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
                                <select name="btn_primary" id="btn-primary" class="form-control custom-select {{ $errors->has('btn_primary') ? 'is-invalid' : '' }}">
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
                                <select name="nav_bg" id="nav-bg" class="form-control custom-select {{ $errors->has('nav_bg') ? 'is-invalid' : '' }}">
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
                            <div class="form-group col-md-4">
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
                                <input class="btn btn-success shadow-sm" type="submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <form action="{{ url('/orientation/'.$orientation->id.'/certificate') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        @if ( count ( $certificate ) === 1 )
                            <input type="hidden" name="certid" value="{{ $certificate[0]->id }}">
                        @endif

                        <div class="card-header d-flex justify-content-between">
                            <span class="lead text-capitalize">
                                Certificate
                                @if ( count ( $certificate ) === 1 )
                                    <a href="{{ url('/certificate/' . $certificate[0]->id) }}" target="_blank">
                                        <i class="fas fa-eye ml-2"></i>
                                    </a>
                                @endif
                            </span>

                            <span class="custom-control custom-checkbox">
                                <input
                                    class="custom-control-input"
                                    id="status"
                                    type="checkbox"
                                    name="status"
                                    @if ( count ( $certificate ) === 1 && $certificate[0]->status === 'on' )
                                        checked
                                    @endif>
                                <label class="custom-control-label" for="status">Enable / Disable</label>
                            </span>
                        </div>
                        <div class="card-body">

                            <label>Paper orientation</label>
                            <div class="form-group">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        id="landscape"
                                        name="po"
                                        value="landscape"
                                        class="custom-control-input"
                                        @if ( count ( $certificate ) === 1 && $certificate[0]->paper_orientation === 'landscape' )
                                            checked
                                        @endif>
                                    <label class="custom-control-label" for="landscape">Landscape</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        id="portrait"
                                        name="po"
                                        value="portrait"
                                        class="custom-control-input"
                                        @if ( count ( $certificate ) === 1 && $certificate[0]->paper_orientation === 'portrait' )
                                            checked
                                        @endif>
                                    <label class="custom-control-label" for="portrait">Portrait</label>
                                </div>
                                @error('po')
                                    <small class="text-danger form-text">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Page bg --}}
                            <div class="form-group">
                                <label for="body_bg">Page background:</label>
                                <input
                                    type="color"
                                    name="body_bg"
                                    id="body_bg"
                                    value="@if ( count($certificate) == 1 ){{ $certificate[0]->body_bg }}@else #ffffff @endif"
                                >
                            </div>

                            {{-- Certificate bg --}}
                            <div class="form-group">
                                <label for="cert_bg">Certificate background:</label>
                                <input
                                    type="color"
                                    name="cert_bg"
                                    id="cert_bg"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->cert_bg}}@else #FFEFBC @endif"
                                >
                            </div>

                            {{-- Certificate text color --}}
                            <div class="form-group">
                                <label for="cert_text_color">Certificate text color:</label>
                                <input
                                    type="color"
                                    name="cert_text_color"
                                    id="cert_text_color"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->cert_text_color}}@else #000000 @endif"
                                >
                            </div>

                            {{-- Footer text color --}}
                            <div class="form-group">
                                <label for="footer_text_color">Footer text color:</label>
                                <input
                                    type="color"
                                    name="footer_text_color"
                                    id="footer_text_color"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->footer_text_color}}@else #000000 @endif"
                                >
                            </div>

                            <hr>

                            {{-- Outer border color --}}
                            <div class="form-group">
                                <label for="cert_border_out_color">Outer border color:</label>
                                <input
                                    type="color"
                                    name="cert_border_out_color"
                                    id="cert_border_out_color"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->cert_border_out_color}}@else #000000 @endif"
                                >
                            </div>

                            {{-- Outer border radius --}}
                            <div class="form-group">
                                <label for="cert_border_out_radius">Outer border radius:</label>
                                <input
                                    type="number"
                                    name="cert_border_out_radius"
                                    id="cert_border_out_radius"
                                    min="0"
                                    max="10"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->cert_border_out_radius}}@else 0 @endif"
                                >
                                px
                            </div>

                            {{-- Outer border thickness --}}
                            <div class="form-group">
                                <label for="cert_border_out_thickness">Outer border thickness:</label>
                                <input
                                    type="number"
                                    name="cert_border_out_thickness"
                                    id="cert_border_out_thickness"
                                    min="0"
                                    max="10"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->cert_border_out_thickness}}@else 1 @endif"
                                >
                                px
                            </div>

                            {{-- Outer border style --}}
                            <div class="form-group">
                                <label for="cert_border_out_style">Outer border style:</label>
                                <select name="cert_border_out_style" id="cert_border_out_style">
                                    <option value="solid"  @if( count ( $certificate ) === 1 && $certificate[0]->cert_border_out_style === 'solid' ) selected @endif>Solid line</option>
                                    <option value="dashed" @if( count ( $certificate ) === 1 && $certificate[0]->cert_border_out_style === 'dashed' ) selected @endif>Dashed line</option>
                                    <option value="dotted" @if( count ( $certificate ) === 1 && $certificate[0]->cert_border_out_style === 'dotted' ) selected @endif>Dotted line</option>
                                    <option value="double" @if( count ( $certificate ) === 1 && $certificate[0]->cert_border_out_style === 'double' ) selected @endif>Double line</option>
                                </select>
                            </div>

                            {{-- Inner border color --}}
                            <div class="form-group">
                                <label for="cert_border_in_color">Inner border color:</label>
                                <input
                                    type="color"
                                    name="cert_border_in_color"
                                    id="cert_border_in_color"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->cert_border_in_color}}@else #000000 @endif"
                                >
                            </div>

                            {{-- Inner border radius --}}
                            <div class="form-group">
                                <label for="cert_border_in_radius">Inner border radius:</label>
                                <input
                                    type="number"
                                    name="cert_border_in_radius"
                                    id="cert_border_in_radius"
                                    min="0"
                                    max="10"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->cert_border_in_radius}}@else 0 @endif"
                                >
                                px
                            </div>

                            {{-- Inner border thickness --}}
                            <div class="form-group">
                                <label for="cert_border_in_thickness">Inner border thickness:</label>
                                <input
                                    type="number"
                                    name="cert_border_in_thickness"
                                    id="cert_border_in_thickness"
                                    min="0"
                                    max="10"
                                    value="@if ( count($certificate) === 1 ){{$certificate[0]->cert_border_in_thickness}}@else 1 @endif"
                                >
                                px
                            </div>

                            {{-- Inner border style --}}
                            <div class="form-group">
                                <label for="cert_border_in_style">Inner border style:</label>
                                <select name="cert_border_in_style" id="cert_border_in_style">
                                    <option value="solid"  @if( count ( $certificate ) === 1 && $certificate[0]->cert_border_in_style === 'solid' )  selected @endif >Solid line</option>
                                    <option value="dashed" @if( count ( $certificate ) === 1 && $certificate[0]->cert_border_in_style === 'dashed' )  selected @endif >Dashed line</option>
                                    <option value="dotted" @if( count ( $certificate ) === 1 && $certificate[0]->cert_border_in_style === 'dotted' )  selected @endif >Dotted line</option>
                                    <option value="double" @if( count ( $certificate ) === 1 && $certificate[0]->cert_border_in_style === 'double' )  selected @endif >Double line</option>
                                </select>
                            </div>

                            <div class="form-group d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
