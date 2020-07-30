@if($role->contains('admin') || $role->contains('advisor'))
    @error('enroll')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror

    <table class="table table-hover table-borderless">
        <tbody>
            @forelse ($orientations as $orientation)
            <tr class="align-middle">
                <td>
                    <a type="button" class="text-capitalize btn btn-block text-left text-primary" href="/orientation/{{ $orientation->id }}">
                        <p class="mb-0 lead">
                            {{ $orientation->name }}
                        </p>
                    </a>
                </td>
                <td align="right" class="align-middle">
                    <a class="btn btn-sm text-secondary" type="button" title="Settings" href="/orientation/{{ $orientation->id }}/edit"><i class="fas fa-sliders-h"></i></a>
                    <a class="btn btn-sm text-secondary" type="button" title="Enrolled students" href="/orientation/{{ $orientation->id }}/stats"><i class="fas fa-chart-bar mr-1"></i>{{ $orientation->users->count() }}</a>
                    <a class="btn btn-sm btn-link text-primary" type="button" title="Enroll students." data-toggle="modal" data-target="#enroll{{$orientation->id}}">Enroll students</a>
                </td>
            </tr>

            <div class="modal fade" id="enroll{{$orientation->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="enrolling{{$orientation->id}}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="enrolling{{$orientation->id}}">Enroll students in {{$orientation->name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        action="/orientation/{{ $orientation->id }}/enroll"
                        method="post">
                    <div class="modal-body">
                        <p class="lead">Select one or more students to begin.</p>
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                @foreach ($students as $student)
                                    <div class="custom-control custom-checkbox my-2">
                                        <input class="custom-control-input" type="checkbox" value="{{ $student->id }}" id="user{{ $orientation->id }}{{ $student->id }}" name="enroll[]">
                                        <label class="custom-control-label" for="user{{ $orientation->id }}{{ $student->id }}">
                                            {{ $student->name }} - {{ $student->email }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                            <button type="submit" class="btn btn-primary">Enroll</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            @empty

            <p class="text-center">Click <strong>Add orientation</strong> to get started.</p>

            @endforelse
        </tbody>
    </table>
@endif
