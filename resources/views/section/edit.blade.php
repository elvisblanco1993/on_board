@extends('layouts.app')

@section('content')
    @if ($section->types[0]->name === 'text')
        @include('section.edit.text')
    @endif

    @if ($section->types[0]->name === 'media')
        @include('section.edit.media')
    @endif

    @if ($section->types[0]->name === 'assessment')
        @include('section.edit.assessment')
    @endif
@endsection
