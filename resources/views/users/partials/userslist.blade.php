<div class="card">

    <div class="card-header d-flex justify-content-between">
        <span class="lead text-capitalize">
            users
        </span>
        <a href="{{ url('/users/invite') }}" title="Invite users">
            <i class="fas fa-user-plus"></i> Invite
        </a>
    </div>


    <div class="card-body">

        <div class="row">

            @foreach ($users as $user)
                <div class="col-md-3">
                    <a href="{{ url('/users/' . $user->id) }}" class="custom-card">
                        <div class="card user-card">
                            <div class="card-body">
                                <div class="media">
                                    <img src="{{ url('/storage/images/' . $user->avatar) }}" alt="{{$user->name}}" class="avatar rounded-pill mr-3" width="96" height="96">
                                    <div class="media-body align-self-center">
                                        <h5 class="mt-0 text-dark">{{$user->name}}</h5>
                                        <p class="text-muted mb-0">{{$user->email}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
















        <table class="table table-hover table-borderless">
            <tbody>
                @foreach ($users as $user)
                    <div class="modal fade" id="userDetails{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="userDetails" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="userDetails">Editing: {{ $user->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <form action="/user/{{ $user->id }}/update" method="POST">
                                    <div class="modal-body">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                          <label for="name">Name</label>
                                          <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="form-control"
                                            placeholder="John Smith"
                                            value="{{ $user->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="roles">Role</label>
                                            <select name="role" class="custom-select text-capitalize">
                                                @foreach ($appRoles as $appRole)
                                                <option
                                                    class="text-capitalize"
                                                    value="{{ $appRole->id }}"
                                                    @if ( !empty($user->roles[0]->id) )
                                                        @if ($user->roles[0]->id == $appRole->id)
                                                            selected
                                                        @endif
                                                    @endif
                                                    >{{ $appRole->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        {{-- Pending invitations --}}
        @if (count($pendingInvites) > 0)
        <hr>
        <div class="lead mb-2">
            Pending invitations
        </div>
        <table class="table table-hover table-borderless">
            <tbody>
                @foreach ($pendingInvites as $invitee)

                <tr>
                    <td class="align-middle">
                        <div class="media">
                            <div class="media-body">
                                <p class="mb-0">{{ $invitee->name }}</p>
                                <span class="text-muted">
                                    <a href="mailto:{{ $invitee->email }}">{{ $invitee->email }}</a>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle d-flex float-right" align="right">
                        <form action="/users/{{ $invitee->id }}/resend" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-link mx-1 p-1 text-secondary" title="Re-send invitation">
                                <i class="far fa-paper-plane"></i>
                            </button>
                        </form>

                        <form action="/users/{{ $invitee->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link mx-1 p-1 text-danger" title="Delete entry">
                                <i class="fas fa-trash-alt    "></i>
                            </button>
                        </form>
                    </td>

                </tr>

                @endforeach
            </tbody>
        </table>
        @endif


    </div>
</div>
