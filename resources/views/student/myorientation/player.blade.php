@extends('layouts.app')
@section('content')

<style>
    body{
        background-image: url('/storage/images/{{ $orientation->background }}');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>
<div class="container" >
    <div class="row">

        <div class="col-md-12 py-5">

            @if ($section->types[0]->name == 'text')

                @include('student.myorientation.text')

            @endif

            @if ($section->types[0]->name == 'media')

                @include('student.myorientation.media')

            @endif

            @if ($section->types[0]->name == 'assessment')

                @include('student.myorientation.assessment')

            @endif

        </div>

    </div>
</div>
@endsection
