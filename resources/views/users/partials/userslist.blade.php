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

        <table class="table table-hover table-borderless">
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="media">
                                <div class="media-body">
                                    <p class="mb-0">{{ $user->name }}</p>
                                    <span class="text-muted">
                                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td align="right" class="align-middle">
                            <a type="button" class="mx-1 p-1 text-secondary" data-toggle="modal" data-target="#userDetails{{ $user->id }}"><i class="fas fa-user-cog"></i></a>
                        </td>
                    </tr>

                    <div class="modal fade" id="userDetails{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="userDetails" aria-hidden="true">
                        <div class="modal-dialog">
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
