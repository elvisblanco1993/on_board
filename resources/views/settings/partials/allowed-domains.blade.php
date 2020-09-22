<div class="card">

    <div class="card-header d-flex justify-content-between">

        <span class="lead">
            <i class="fas fa-globe-americas mr-2 text-muted"></i>
            Allowed Domains
        </span>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-12">

                <form action="{{ url('settings') . '/store/whitelist' }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <input class="form-control" type="text" name="whitelist">
                        <small class="form-text text-muted">Enter your allowed domains separated by comma.</small>
                    </div>
                    @error('whitelist')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="d-flex justify-content-end">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
                        </div>
                    </div>
                </form>

            </div>

            {{-- List the domains in the whitelist --}}
            <div class="col-md 12">

                @forelse ($whitelist as $domain)

                    <div class="badge badge-light" title="Remove domain from whitelist.">
                        <form action=" {{ url('settings') . '/domain/' . $domain->id }} " method="post">
                            {{ $domain->domain }}
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-link p-0 pb-1 text-danger" type="submit">
                                &times;
                            </button>
                        </form>
                    </div>

                @empty

                @endforelse
            </div>

        </div>

    </div>

</div>
