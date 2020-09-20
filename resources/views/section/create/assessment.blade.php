@if ($role->contains('admin'))

    <form action="/assessment" method="POST">

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
            <label for="body">Question text</label>
            <textarea name="body" id="body-ckeditor" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"></textarea>
            <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
            <script>
                CKEDITOR.replace( 'body-ckeditor' );
            </script>
            @error('body')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <label for="options">Answers <i class="fas fa-info-circle text-secondary" title="You can create True / False questions by using the first two options and marking one as correct."></i></label>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-1">
                        <input type="checkbox" title="Select if answer is correct." name="correct1">
                    </span>
                </div>
                <input type="text" name="option1" class="form-control {{ $errors->has('option1') ? 'is-invalid' : '' }}" placeholder="Option 1">
            </div>
            @error('option1')
                <small class="text-danger">{{ $message }}</small>
            @enderror

        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-2">
                        <input type="checkbox" title="Select if answer is correct." name="correct2">
                    </span>
                </div>
                <input type="text" name="option2" class="form-control {{ $errors->has('option2') ? 'is-invalid' : '' }}" placeholder="Option 2">
            </div>
            @error('option2')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-3">
                        <input type="checkbox" title="Select if answer is correct." name="correct3">
                    </span>
                </div>
                <input type="text" name="option3" class="form-control" placeholder="Option 3">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-4">
                        <input type="checkbox" title="Select if answer is correct." name="correct4">
                    </span>
                </div>
                <input type="text" name="option4" class="form-control" placeholder="Option 4">
            </div>
        </div>

        <div class="form-group">
            <div class="float-right">
                <a class="btn btn-light mr-2" href="{{ url()->previous() }}">Discard</a>
                <button class="btn btn-primary shadow-sm" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
            </div>
        </div>

    </form>

@endif
