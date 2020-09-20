@extends('layouts.app')

@section('content')
    @if ($role->contains('admin') || $role->contains('advisor'))
        <div class="container">
            <div class="row my-4 d-flex justify-content-center">
                @include('layouts.sidebar')

                <div class="col-md-10">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif
                    @if (session('errMessage'))
                        <div class="alert alert-warning" role="alert">
                            <strong>{{ session('errMessage') }}</strong>
                        </div>
                    @endif

                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <span>
                                    <a href="{{ url('dashboard') }}" class="mr-3">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>

                                    <span class="lead text-capitalize">
                                        {{ $orientation->name }}
                                    </span>
                                </span>

                                <a class="text-primary" href="/section/create/{{ $orientation->id }}">
                                    <i class="fas fa-plus-circle"></i> Add section
                                </a>
                            </div>
                        </div>

                        <div class="card-body">

                            <table class="table table-hover ">

                                <tbody>

                                    @forelse ($orientation->sections as $section)
                                        <tr>
                                            <td class="align-middle">
                                                @if ($section->types[0]->id == 1)
                                                    <i class="far fa-file-code"></i>
                                                @endif
                                                @if ($section->types[0]->id == 2)
                                                    <i class="fas fa-film"></i>
                                                @endif
                                                @if ($section->types[0]->id == 3)
                                                    <i class="fas fa-question-circle"></i>
                                                @endif
                                                {{ $section->name }}

                                            </td>
                                            <td align="right">

                                                <div class="btn-group">
                                                    <button class="btn btn-link" onclick="window.location.href='/section/{{ $section->id }}/edit'">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    @if ($role->contains('admin') && count($orientation->users) === 0)

                                                        <button type="button" class="btn btn-link text-danger" data-toggle="modal" data-target="#del{{ $section->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>

                                                        <div class="modal fade" id="del{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="del{{ $section->id }}Label" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="del{{ $section->id }}Label">Deleting {{ $section->name }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-left">
                                                                    <p class="lead">Are you sure you want to delete this section?</p>
                                                                    <p>All data related to this section will be lost.</p>
                                                                    <form action="/section/{{ $section->id }}/delete" method="POST">
                                                                        @csrf
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

                                                </div>

                                            </td>
                                        </tr>

                                    @empty

                                    <p class="text-center">Click <strong>Add section</strong> to get started.</p>

                                    @endforelse

                                </tbody>
                            </table>

                        </div>

                        @if ($role->contains('admin') && count($orientation->sections) === 0)

                            <div class="card-footer">
                                <button
                                type="button"
                                class="btn btn-sm btn-link text-danger float-right"
                                data-toggle="modal"
                                data-target="#del{{ $orientation->id }}"
                                title="Delete Orientation">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>

                            <div class="modal fade" id="del{{ $orientation->id }}" tabindex="-1" role="dialog" aria-labelledby="del{{ $orientation->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="del{{ $orientation->id }}Label">Deleting {{ $orientation->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="lead">Are you sure you want to delete this orientation?</p>
                                            <p>All data related to this orientation will be lost.</p>
                                            <form action="/orientation/{{ $orientation->id }}" method="post">
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

                    </div>

                    @include('dashboards.include.modals')
                </div>
            </div>
        </div>
    @endif
@endsection

































{{-- <ul class="list-group">
    @foreach ($orientation->sections as $section)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                @if ($section->types[0]->id == 1)
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-richtext" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                        <path fill-rule="evenodd" d="M4.5 11.5A.5.5 0 0 1 5 11h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 9h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm1.639-3.708l1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V7.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V7s1.54-1.274 1.639-1.208zM6.25 5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5z"/>
                    </svg>
                @endif
                @if ($section->types[0]->id == 2)
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-film" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm4 0h8v6H4V1zm8 8H4v6h8V9zM1 1h2v2H1V1zm2 3H1v2h2V4zM1 7h2v2H1V7zm2 3H1v2h2v-2zm-2 3h2v2H1v-2zM15 1h-2v2h2V1zm-2 3h2v2h-2V4zm2 3h-2v2h2V7zm-2 3h2v2h-2v-2zm2 3h-2v2h2v-2z"/>
                    </svg>
                @endif
                @if ($section->types[0]->id == 3)
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-question-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M5.25 6.033h1.32c0-.781.458-1.384 1.36-1.384.685 0 1.313.343 1.313 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.007.463h1.307v-.355c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.326 0-2.786.647-2.754 2.533zm1.562 5.516c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                    </svg>
                @endif
                {{ $section->name }}
            </div>
            <div class="btn-group">
                <button class="btn btn-link" onclick="window.location.href='/section/{{ $section->id }}/view'">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-globe2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1.018 7.5h2.49c.037-1.07.189-2.087.437-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5zM3.05 3.049c.362.184.763.349 1.198.49.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05zM8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm-.5 1.077c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.473.257 2.282.287V1.077zm0 4.014c-.91-.03-1.783-.145-2.591-.332a12.344 12.344 0 0 0-.4 2.741H7.5V5.091zm1 2.409V5.091c.91-.03 1.783-.145 2.591-.332.223.827.364 1.754.4 2.741H8.5zm-1 1H4.51c.035.987.176 1.914.399 2.741A13.596 13.596 0 0 1 7.5 10.91V8.5zm1 2.409V8.5h2.99a12.343 12.343 0 0 1-.399 2.741A13.596 13.596 0 0 0 8.5 10.91zm-1 1c-.81.03-1.577.13-2.282.287.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91zm-2.173 2.563a6.695 6.695 0 0 1-.597-.933 8.857 8.857 0 0 1-.481-1.078 8.356 8.356 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.52zM2.38 12.175c.47-.258.995-.482 1.565-.667A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.964 6.964 0 0 0 1.362 3.675zm8.293 2.297a7.01 7.01 0 0 0 2.275-1.521 8.353 8.353 0 0 0-1.197-.49 8.859 8.859 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zm.11-2.276A12.63 12.63 0 0 0 8.5 11.91v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872zm1.272-.688c.57.185 1.095.409 1.565.667A6.964 6.964 0 0 0 14.982 8.5h-2.49a13.355 13.355 0 0 1-.437 3.008zm.437-4.008h2.49a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008zm-.74-3.96a8.854 8.854 0 0 0-.482-1.079 6.692 6.692 0 0 0-.597-.933c.857.355 1.63.875 2.275 1.521a8.368 8.368 0 0 1-1.197.49zm-.97.264c-.705.157-1.473.257-2.282.287V1.077c.67.204 1.335.82 1.887 1.855.143.268.276.56.395.872z"/>
                    </svg>
                </button>
                <button class="btn btn-link" onclick="window.location.href='/section/{{ $section->id }}/edit'">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                    </svg>
                </button>
                <form action="/section/{{ $section->id }}/delete" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </li>
    @endforeach
</ul> --}}
