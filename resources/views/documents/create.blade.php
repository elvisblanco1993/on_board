@extends('layouts.app')

@section('content')

    @if ($role->contains('admin'))
        <div class="container-fluid">
            <div class="row mt-4">
                @include('layouts.sidebar')

                <div class="col-md-10">

                    <div class="card">
                        <div class="card-header">
                            <span class="mb-0 pb-0">
                                <a href="{{ url('documents') }}" class="mr-3">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <span class="lead text-capitalize">
                                    New document
                                </span>
                            </span>
                        </div>

                        <div class="card-body">

                            {{-- Content --}}
                            <form action="/documents" method="post">
                                @csrf

                                <div class="form-group">
                                    <label for="heading">Document name</label>
                                    <input type="text" name="name" id="heading" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" placeholder="" aria-describedby="heading">
                                    @error('name')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <textarea name="content" id="body-ckeditor" class="form-control body" rows="10"></textarea>
                                    <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
                                    <script>
                                        CKEDITOR.replace( 'body-ckeditor' );
                                    </script>
                                    @error('content')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-light mr-2" href="{{route('documents')}}">Discard</a>
                                    <button class="btn btn-primary shadow-sm" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>



    @endif

@endsection
