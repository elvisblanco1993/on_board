<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            {!! $section->body !!}
        </div>
        <div class="card-footer d-flex justify-content-between">
            @if ( !is_null($prev) && $prev !== $current )

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
                    <button class="btn {{ $orientation->btn_primary ?? 'btn-success' }}" id="next">FINISH <i class="far fa-check-circle"></i></button>
                </form>
            @endif
        </div>
    </div>
</div>
