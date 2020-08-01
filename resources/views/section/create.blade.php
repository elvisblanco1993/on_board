@if ($role->contains('admin'))
    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row mt-4">

                @include('layouts.sidebar')

                <div class="col-md-10">

                    <div class="card">

                        <div class="card-header pb-0 d-flex justify-content-between">
                            <span class="mb-0 pb-0">
                                <a href="{{ url('orientation/' . $orientation->id) }}" class="mr-3">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <span class="lead text-capitalize">
                                    New section
                                </span>
                            </span>
                            <form action="/section/create/{{ $orientation->id }}" method="GET">
                                <div class="form-group mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <select class="custom-select custom-select-sm" id="content-type" name="content-type">
                                            <option value="" selected>Select and option</option>
                                            @foreach ($section_types as $type)
                                                <option value="{{ $type->id }}" @if (request('content-type') == $type->id) selected @endif>{{ $type->label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-outline-primary" type="submit">
                                                Select
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <div class="card-body">

                            <div>

                                @if (session('errMessage'))
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Error!</strong> {{ session('errMessage') }}
                                    </div>
                                @endif

                                @if (empty( request('content-type') ))
                                    <p class="text-center mb-0">
                                        Please select an option to get started.
                                    </p>
                                @endif

                                @if (request('content-type') === '1')
                                    @include('section.create.text')
                                @endif
                                @if (request('content-type') === '2')
                                    @include('section.create.media')
                                @endif
                                @if (request('content-type') === '3')
                                    @include('section.create.assessment')
                                @endif
                                @if (request('content-type') === '4')
                                    @include('section.create.docusign')
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endsection

@endif
