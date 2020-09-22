@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <div class="row my-4 d-flex justify-content-center">

            @include('layouts.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>
                            <a href="{{ url('dashboard') }}" class="mr-3">
                                <i class="fas fa-arrow-left"></i>
                            </a>

                            <span class="lead text-capitalize">
                                Statistics
                            </span>
                        </span>
                        @if ( count($students) > 0 )
                            <form action="{{ url('/orientation/' . $students[0]->orientations[0]->id . '/exportStats') }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-primary btn m-0 py-0" title="Download .xslx report">
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body">

                        @if ( session('message') )
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <table class="table table-sm table-borderless table-hover">
                            <tbody>

                                @foreach ($students as $student)

                                <tr>
                                    <td>
                                        <a href="{{ url('/users/' . $student->id) }}">
                                            <div class="media">
                                                <div class="media-body">
                                                    <p class="my-0">{{ $student->name }}</p>
                                                    {{ $student->email }}
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td align="right" class="align-middle">
                                        @if ($student->pivot->completed_at)
                                            <span class="bg-success rounded-lg p-1">
                                                <i class="fas fa-check-circle"></i>
                                                Completed on:
                                                {{ date('M d, Y', strtotime($student->pivot->completed_at)) }}
                                            </span>
                                        @else

                                        <i class="fas fa-spinner text-muted"></i>
                                        <a type="button" title="Unenroll student" class="ml-3" data-toggle="modal" data-target="#unenroll{{ $student->id }}">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="unenroll{{ $student->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Unenroll {{ $student->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        <p class="lead">Are you sure you want to unenroll this student?</p>
                                                        <p>Any progress made by the student will be permanently lost.</p>
                                                        <form action="/orientation/{{ $orientation->id }}/unenroll/{{ $student->id }}" method="post">
                                                            @csrf
                                                            @method('PUT')


                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-light mr-2" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">I understand. Unenroll</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
