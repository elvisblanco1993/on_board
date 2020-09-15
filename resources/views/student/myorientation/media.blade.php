<div class="col-md-12">
    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    {{-- Video JS --}}
                    <link href="{{ asset('css/video-js.css') }}" rel="stylesheet" />

                    <video
                        id="v-player"
                        class="video-js vjs-big-play-centered"
                        controls
                        data-setup='{ "techOrder": ["{{ $section->provider }}"], "sources": [{ "type": "video/{{ $section->provider }}", "src": "{{ $section->video }}"}]}'
                    >
                    </video>

                    <script src="{{ asset('js/video.js') }}"></script>
                    @if ($section->provider == 'youtube')
                        <script src="{{ asset('js/Youtube.js') }}"></script>
                    @endif
                    @if ($section->provider == 'vimeo')
                        <script src="{{ asset('js/videojs-vimeo.js') }}"></script>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            @if ( ! is_null ( $prev ) && $prev !== $current )

                <form action="/player/{{ $orientation->id }}/section/{{ $prev }}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn {{ $orientation->btn_secondary ?? 'btn-light' }}" id="prev"><i class="fas fa-chevron-left mr-2"></i> PREVIOUS</button>
                </form>

            @else
            <button class="btn {{ $orientation->btn_secondary ?? 'btn-light' }}" disabled><i class="fas fa-chevron-left mr-2"></i> PREVIOUS</button>

            @endif
            @if ( ! is_null ( $next ) && $next !== $current )

                <form action="/player/{{ $orientation->id }}/section/{{ $next }}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn {{ $orientation->btn_primary ?? 'btn-primary' }}" id="next" {{ $section->video ? 'disabled' : '' }} >NEXT <i class="fas fa-chevron-right ml-2"></i></button>
                </form>
            @else
                <form action="/player/{{ $orientation->id }}/finish/{{ $current }}" method="post">
                    @csrf
                    @method('PUT')
                    {{-- Completes the section and the orientation --}}
                    <button class="btn {{ $orientation->btn_primary ?? 'btn-success' }}" id="next" disabled>FINISH <i class="far fa-check-circle ml-2"></i></button>
                </form>
            @endif
        </div>

    </div>
    {{-- Video Description --}}
    @if ( !is_null( $section->body ) )
        <div class="card mt-4">
            <div class="card-body">
                {!! $section->body !!}
            </div>
        </div>
    @endif
</div>

<script>
    var video = videojs('v-player', {
        fluid: true,
    });

    let section = {{ $section->id }};
    let isDone = localStorage.getItem(section);

    if (isDone !== null) {
        document.querySelector('#next').disabled = false;
    }

    video.on('ended', () => {
        // Mark the video as viewed, and enable the button from this point forward.
        if (isDone == null) {
            localStorage.setItem(section, 'done');
        }

        document.querySelector('#next').disabled = false;
    });
</script>
