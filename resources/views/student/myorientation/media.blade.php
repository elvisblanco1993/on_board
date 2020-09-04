<div class="col-md-10">
    <div class="card my-5">
        <div class="card-body">
            <div class="row">
                @if ( !is_null( $section->body ) )
                    <div class="col-md-6">
                        {!! $section->body !!}
                    </div>
                @endif
                <div class="col">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video
                            class="shadow rounded-lg"
                            style="outline: none"
                            src="/storage/videos/{{ $section->video }}"
                            controls>
                        </video>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            @if ( $prev !== $current )

                <form action="/player/{{ $orientation->id }}/section/{{ $prev }}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn {{ $orientation->btn_secondary ?? 'btn-light' }}" id="prev"><i class="fas fa-chevron-left"></i> PREVIOUS</button>
                </form>

            @else
            <button class="btn {{ $orientation->btn_secondary ?? 'btn-light' }}" disabled><i class="fas fa-chevron-left"></i> PREVIOUS</button>

            @endif
            @if ( ! is_null ( $next ) && $next !== $current )

                <form action="/player/{{ $orientation->id }}/section/{{ $next }}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn {{ $orientation->btn_primary ?? 'btn-primary' }}" id="next" {{ $section->video ? 'disabled' : '' }} >NEXT <i class="fas fa-chevron-right"></i></button>
                </form>
            @else
                <form action="/player/{{ $orientation->id }}/finish/{{ $current }}" method="post">
                    @csrf
                    @method('PUT')
                    {{-- Completes the section and the orientation --}}
                    <button class="btn {{ $orientation->btn_primary ?? 'btn-success' }}" id="next" disabled>FINISH <i class="far fa-check-circle"></i></button>
                </form>
            @endif
        </div>
    </div>
</div>

<script type="text/javascript">
    const video = document.querySelector('video');
    let section = {{ $section->id }};

    let isDone = localStorage.getItem(section);

    if (isDone !== null) {
        document.querySelector('#next').disabled = false;
    }
    else
    {
        video.onended = (event) => {
        // Mark the video as viewed, and enable the button from this point forward.
        if (isDone == null) {
            localStorage.setItem(section, 'done');
        }
            document.querySelector('#next').disabled = false;
        };
    }
</script>
