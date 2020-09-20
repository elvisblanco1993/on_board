@if ($role->contains('admin'))
    <form action="/section" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="type" value="{{ request('content-type') }}">
        <input type="hidden" name="orientation" value="{{ $orientation->id }}">

        <div class="form-group">
            <label for="heading">Title <span class="text-danger">*</span></label>
            <input
                type="text"
                name="name"
                id="heading"
                class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                placeholder=""
                aria-describedby="heading"
                value="{{ old('name') }}">
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="url">URL<span class="text-danger">*</span></label>
            <div class="form-row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Provider</span>
                        </div>
                        <select class="custom-select {{$errors->has('video') ? 'is-invalid' : ''}}" name="provider">
                            <option value="youtube"><i class="fab fa-vimeo"></i>Youtube</option>
                            <option value="vimeo">Vimeo</option>
                        </select>
                    </div>

                </div>
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Video</span>
                        </div>
                        <input class="form-control {{$errors->has('video') ? 'is-invalid' : ''}}" type="url" name="video" id="url">
                    </div>
                    <small class="form-text text-muted">Accepts complete video url.</small>
                </div>
            </div>
            @if ($errors->has('provider'))
                <p class="text-danger">{{$errors->first('provider')}}</p>
            @endif
            @if ($errors->has('video'))
                <p class="text-danger">{{$errors->first('video')}}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="body" id="description" cols="30" rows="10">{{ old('body') }}</textarea>
            <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
            <script>
                CKEDITOR.replace( 'description' );
            </script>
        </div>
        <div class="form-group float-right">
            <a class="btn btn-light mr-2" href="{{ url()->previous() }}">Discard</a>
            <button class="btn btn-primary shadow-sm" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
        </div>
    </form>
@endif
