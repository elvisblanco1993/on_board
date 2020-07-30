<form action="{{ url('settings') . '/store/frontpage' }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <textarea class="form-control {{ $errors->has('frontpage') ? 'is-invalid' : '' }}" name="frontpage" id="fpage" cols="30" rows="10" placeholder="Insert your html here..">{{ $settings->frontpage }}</textarea>
    </div>
    @error('frontpage')
        <p class="text-danger">{{ $message }}</p>
    @enderror
    <div class="d-flex justify-content-end">
        <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
        </div>
    </div>
</form>
