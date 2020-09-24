@if (session('message'))
    <div class="snackbar snackbar-success">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('message') }}
    </div>
@endif

@if (session('errMessage'))
    <div class="snackbar snackbar-danger">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('errMessage') }}
    </div>
@endif

@error('logo')
    <div class="snackbar snackbar-danger">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{$message}}
    </div>
@enderror

@error('enroll')
    <div class="snackbar snackbar-danger">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{$message}}
    </div>
@enderror
