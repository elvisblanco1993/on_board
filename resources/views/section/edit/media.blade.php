@if ($role->contains('admin') || $role->contains('advisor'))
<section class="container">
    <form action="/section/{{ $section->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="type" value="{{$section->types[0]->id}}">

        <div class="row my-4">

            @include('layouts.sidebar')

            <div class="col-md-10">
                <div class="card">

                    <div class="card-header">
                        <a href="{{ url('dashboard') }}" class="mr-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <span class="lead text-capitalize">
                            Edit section
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="heading">Video Title <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="name"
                                id="heading"
                                class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                                aria-describedby="heading"
                                value="{{ $section->name }}">

                            @if ($errors->has('name'))
                                <p class="text-danger">{{$errors->first('name')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea
                                class="form-control"
                                name="body"
                                id="body"
                                cols="30"
                                rows="10">{{ $section->body }}</textarea>
                            <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
                            <script>
                                CKEDITOR.replace( 'body' );
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="url">Upload video<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input
                                        name="video"
                                        type="file"
                                        class="custom-file-input {{$errors->has('video') ? 'is-invalid' : ''}}"
                                        id="videoUload"
                                        aria-describedby="video">

                                    <label
                                        class="custom-file-label"
                                        for="videoUload">{{ $section->video }}</label>
                                </div>
                            </div>
                            @if ($errors->has('video'))
                                <p class="text-danger">{{$errors->first('video')}}</p>
                            @endif
                        </div>
                        <div class="form-group float-right">
                            <a class="btn btn-light mr-2" href="{{ url()->previous() }}">Discard</a>
                            <button class="btn btn-primary shadow-sm" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endif
