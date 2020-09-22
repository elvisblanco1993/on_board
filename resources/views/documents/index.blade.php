@extends('layouts.app')
@section('content')
    @if ($role->contains('admin'))
        <div class="container-xl">
            <div class="row my-4 ">

                @include('layouts.sidebar')

                <div class="col-md-10">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <span class="lead text-capitalize">
                                Documents
                            </span>
                            <a  type="button"
                                class="text-primary mb-0"
                                href="{{ url('documents/new') }}">
                                <i class="fas fa-plus-circle mr-1"></i>New
                            </a>
                        </div>
                        <div class="card-body">

                            @if (session('message'))
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle"></i>
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if (session('errMessage'))
                                <div class="alert alert-warning" role="alert">
                                    <i class='fas fa-exclamation-circle'></i>
                                    <strong>{{ session('errMessage') }}</strong>
                                </div>
                            @endif

                            @error('orientation')
                                <div class="alert alert-danger" role="alert">
                                    <i class='fas fa-exclamation-circle'></i>
                                    <strong>Error! </strong> At least one orientation must be selected.
                                </div>
                            @enderror



                            <table class="table table-hover table-borderless">
                                <tbody>
                                    @foreach ($documents as $document)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $document->name }}
                                            </td>
                                            <td class="align-middle" align="right">
                                                <div class="btn-group">

                                                    <button class="btn btn-link" title="View / download document." onclick="window.open('/documents/{{ $document->id }}')">
                                                        {{-- View document --}}
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    <button class="btn btn-link" title="Attach to orientation." data-toggle="modal" data-target="#attachTo{{ $document->id }}" >
                                                        {{-- Attach document to an orientation --}}
                                                        <i class="fas fa-share-square"></i>
                                                    </button>

                                                    <button class="btn btn-link" title="Edit document." onclick="window.location.href='/documents/{{ $document->id }}/edit'">
                                                        {{-- Edit document --}}
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    {{-- Only show a Delete option if the document is not associated with an user. --}}
                                                    @if ( count($document->users) === 0 )
                                                    <button class="btn btn-link" title="Delete document." data-toggle="modal" data-target="#del{{ $document->id }}">
                                                        {{-- Delete document --}}
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Attach document to an orientation --}}
                                        <div class="modal fade" id="attachTo{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="attachTo{{ $document->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="attachTo{{ $document->id }}Label">Attach to...</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/documents/{{ $document->id }}/attach" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <select name="orientation[]" class="form-control custom-select" multiple>
                                                                @forelse ($orientations as $orientation)
                                                                    <option value="{{ $orientation->id }}">{{ $orientation->name }}</option>
                                                                @empty
                                                                    <option class="disabled" disabled>Please create at least one orientation to begin.</option>
                                                                @endforelse
                                                            </select>
                                                        </div>

                                                        <div class="text-right">
                                                            <button type="button" class="btn btn-light mr-2" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Attach</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        {{-- Only show these options if the document is not associated with an user. --}}
                                        @if ( count($document->users) === 0 )
                                            {{-- Delete confirmation modal --}}
                                            <div class="modal fade" id="del{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="del{{ $document->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="del{{ $document->id }}Label">Deleting {{ $document->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="lead">Are you sure you want to delete this document?</p>
                                                        <p>All data related to this document will be lost.</p>
                                                        <form action="/documents/{{ $document->id }}/delete" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-light mr-2" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection
