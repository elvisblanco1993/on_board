@if (session('message'))
    <div class="snackbar snackbar-success">
        <i class="fas fa-check-circle"></i>
        <strong>{{ session('message') }}</strong>
    </div>
@endif

@if (session('errMessage'))
    <div class="snackbar snackbar-danger">
        <i class="fas fa-exclamation-circle"></i>
        <strong>{{ session('errMessage') }}</strong>
    </div>
@endif

@error('logo')
    <div class="snackbar snackbar-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{$message}}
    </div>
@enderror
