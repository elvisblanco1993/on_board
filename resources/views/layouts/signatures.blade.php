<div class="card my-4">
    <div class="card-header">
        Signatures
    </div>
    <div class="card-body">

        @forelse ($user->signatures as $signature)

        @empty
            <p class="text-center p-2">You haven't added any signatures yet.</p>
        @endforelse

        {{--  --}}

    </div>
</div>
