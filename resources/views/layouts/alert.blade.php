@if (session('message'))
<div class="snackbar snackbar-success">
    <strong>{{ session('message') }}</strong>
</div>

@endif
@if (session('errMessage'))
    <div class="snackbar snackbar-danger">
        <strong>{{ session('errMessage') }}</strong>
    </div>
@endif

@error('logo')
    <div class="snackbar snackbar-danger">
        {{$message}}
    </div>
@enderror
