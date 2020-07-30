<div class="col-md-10">
    <div class="card my-5">
        <div class="card-body">
            <div class="row">

                <div class="col-md-8">

                    <span class="mb-2">
                        {!! $section->body !!}
                    </span>

                    @if ( ! is_null( $possibleAnswers ) )

                        @foreach ($possibleAnswers as $answer)

                            {{-- Give me the options --}}
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="answer{{ $answer->id }}" name="answer" class="custom-control-input" value="{{ $answer->is_correct }}">
                                    <label class="custom-control-label" for="answer{{ $answer->id }}">{{ $answer->answer }}</label>
                                </div>
                            </div>

                        @endforeach

                    @endif

                    <div class="form-group">
                        <button class="btn {{ $orientation->btn_secondary ?? 'btn-success' }}" id="checkAnswer" onclick="validate()">
                            Check my answer
                        </button>
                    </div>

                    {{-- Javascript feedback --}}
                    <span id="feedback"></span>

                </div>

                <div class="col-md-4">
                    {{-- Put image here --}}
                </div>

            </div>

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
            @if ( !is_null($next) && $next !== $current )

                <form action="/player/{{ $orientation->id }}/section/{{ $next }}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn {{ $orientation->btn_primary ?? 'btn-primary' }}" id="next" disabled>NEXT <i class="fas fa-chevron-right"></i></button>
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

{{-- Manipulation script --}}
<script type="text/javascript">

    let answerSelected = document.getElementsByName('answer');
    let done = localStorage.getItem({{ $section->id }});

    if (done == 'done') {
        document.querySelector('#next').disabled = false;

        document.querySelector('#feedback').innerHTML = "<div class='alert alert-success' role='alert'><i class='fa fa-check-circle' aria-hidden='true'></i> <strong>Yayyy!</strong> You got it right.</div>";
    }

    function validate() {
        for (let index = 0; index < answerSelected.length; index++) {
            if (answerSelected[index].checked && answerSelected[index].value == 1) {
                localStorage.setItem({{ $section->id }}, 'done');
                document.querySelector('#feedback').innerHTML = "<div class='alert alert-success' role='alert'><i class='fa fa-check-circle' aria-hidden='true'></i> <strong>Yayyy!</strong> You got it right.</div>";
                document.querySelector('#next').disabled = false;
                break;
            }


            if (answerSelected[index].checked && answerSelected[index].value == 0) {
                localStorage.setItem({{ $section->id }}, null);
                document.querySelector('#feedback').innerHTML = "<div class='alert alert-danger' role='alert'><strong>Not quite</strong>. Please try again.</div>";
                document.querySelector('#next').disabled = true;
                break;
            }
        }
    }

</script>
