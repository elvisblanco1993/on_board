<div class="card w-100 mt-4">
    <div class="card-body py-4">
        <div class="alert alert-info">
            <i class="fas fa-file-contract mr-2"></i>
            You have pending documents.
        </div>
        <p>Please review and sign the documents listed below.</p>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('message') }}
            </div>
        @endif

        @if (session('errMessage'))
            <div class="alert alert-danger" role="alert">
                {{ session('errMessage') }}
            </div>
        @endif

        <table class="table table-borderless table-hover">
            <tbody>

                @foreach ($documents as $document)
                <tr>
                    <td>{{ $document->name }}</td>
                    <td class="text-right">
                        @if ( is_null( $document->pivot->signed_at ) )
                            <a class="text-secondary" type="button" data-toggle="modal" data-target="#doc{{ $document->id }}">
                                <i class="fas fa-file-signature"></i>
                                Review and Sign
                            </a>

                        @else
                            <span class="badge badge-success" title="Signed on {{ $document->pivot->signed_at }}">
                                <i class="fas fa-check-circle"></i>
                                {{ $document->pivot->signed_at }}
                            </span>
                            <a href="{{ url( '/document/view/' . $document->id . '/signed-by/' . $user->id ) }}" target="_blank" title="Download a copy of this signed document." class="ml-2">
                                <i class="fas fa-file-pdf text-danger"></i>
                            </a>
                        @endif

                    </td>
                </tr>

                {{-- Document Modal --}}
                <div class="modal fade" id="doc{{ $document->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="doc{{ $document->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="doc{{ $document->id }}Label">{{ $document->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="{{ url('/documents/' . $document->id) . '/sign' }}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">
                                    {!! $document->content !!}
                                    <hr>
                                    <p>Student Name: <u><i>{{ $user->name }}</i></u></p>
                                    <p>Date Signed: <u>{{ date('M d, Y  h:i:s a') }}</u></p>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="validate{{$document->id}}" onchange="document.getElementById('submit{{$document->id}}').disabled = !this.checked;">
                                        <label class="custom-control-label" for="validate{{$document->id}}">
                                        I understand that by checking this button, this document will be digitally signed under my name.</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="user" value="{{ $user->id }}">
                                    <button type="button" class="btn btn-light align-left" data-dismiss="modal">Dismiss</button>
                                    <button type="submit" class="btn btn-primary" disabled id="submit{{$document->id}}">Agree and Sign</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- End of Document Modal --}}
                @endforeach

            </tbody>
        </table>

    </div>
</div>
