@if ($role->contains('admin'))
    <form action="/section" method="post">
        @csrf
        <input type="hidden" name="type" value="{{ request('content-type') }}">
        <input type="hidden" name="orientation" value="{{ $orientation->id }}">

        <div class="form-group">
            <label for="heading">Section label</label>
            <input type="text" name="name" id="heading" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" placeholder="" aria-describedby="heading">
            @error('name')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="form-group">
            <textarea name="body" id="body-ckeditor" class="form-control body" rows="10"></textarea>
            <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
            <script>
                CKEDITOR.replace( 'body-ckeditor' );
            </script>
            @error('body')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="float-right">
            <a class="btn btn-light mr-2" href="{{ url()->previous() }}">Discard</a>
            <button class="btn btn-primary shadow-sm" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
        </div>
    </form>
@endif
