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
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <a href="{{ url('/users/' . $user->id) }}" class="custom-card">
                        <div class="card user-card">
                            <div class="card-body">
                                <div class="media">
                                    @if ( $user->avatar )
                                        <img
                                            src="{{ url('/storage/images/' . $user->avatar) }}"
                                            alt="{{$user->name}}"
                                            class="avatar rounded-circle mr-3"
                                            width="96"
                                            height="96">
                                    @endif
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
