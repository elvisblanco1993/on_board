@if ($role->contains('admin') || $role->contains('advisor'))
    <section class="container-fluid">
        <form action="/section/{{ $section->id }}" method="post">
            @csrf
            @method('PUT')
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

                                <label for="heading">Label</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="heading"
                                    class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                                    aria-describedby="heading"
                                    value="{{ $section->name }}">

                                    @error('name')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror

                            </div>
                            <div class="form-group">

                                <textarea
                                    name="body"
                                    id="body-ckeditor"
                                    class="form-control body"
                                    rows="10">{{ $section->body }}</textarea>

                                    <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
                                <script>
                                    CKEDITOR.replace( 'body-ckeditor' );
                                </script>
                                @error('body')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror

                            </div>
                            <div class="form-group float-right">
                                <a class="btn btn-light mr-2" href="{{route('dashboard')}}">Discard</a>
                                <button class="btn btn-primary shadow-sm" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endif
