@if ($role->contains('admin'))
    <form action="/section" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="type" value="{{ request('content-type') }}">
        <input type="hidden" name="orientation" value="{{ $orientation->id }}">

        <div class="form-group">
            <label for="heading">Video Title <span class="text-danger">*</span></label>
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
            <label for="url">Upload video<span class="text-danger">*</span></label>
            <div class="input-group">
                <div class="custom-file">
                    <input name="video" type="file" class="custom-file-input {{$errors->has('video') ? 'is-invalid' : ''}}" id="videoUload" aria-describedby="video">
                    <label class="custom-file-label" for="videoUload">Choose video</label>
                </div>
            </div>
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
            <a class="btn btn-light mr-2" href="{{route('dashboard')}}">Discard</a>
            <button class="btn btn-primary shadow-sm" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
        </div>
    </form>
@endif
