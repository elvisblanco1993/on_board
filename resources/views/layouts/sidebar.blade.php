<div class="col-md-2 pl-0">

    <ul class="nav flex-column">

        @if (isset($role) && $role->contains('admin') || isset($role) && $role->contains('advisor'))
        <li class="nav-item">
            <a href="{{ url('dashboard') }}" class="nav-link" style="color: {{ Route::current()->getName() == 'dashboard' ? '#3273dc' : '#2a5164' }}">
                <i class="fas fa-home mr-2" style="color: {{ Route::current()->getName() == 'dashboard' ? '#3273dc' : '#c3cbd3' }}"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('users') }}" class="nav-link" style="color: {{ Route::current()->getName() == 'users' ? '#3273dc' : '#2a5164' }}">
                <i class="fas fa-user-friends mr-2" style="color: {{ Route::current()->getName() == 'users' ? '#3273dc' : '#c3cbd3' }}"></i>
                Users
            </a>
        </li>
        @endif

        @if (isset($role) && $role->contains('admin'))
        <li class="nav-item">
            <a href="{{ url('settings') }}" class="nav-link" style="color: {{ Route::current()->getName() == 'settings' ? '#3273dc' : '#2a5164' }}">
                <i class="fas fa-cogs mr-2" style="color: {{ Route::current()->getName() == 'settings' ? '#3273dc' : '#c3cbd3' }}"></i>
                Settings
            </a>
        </li>
        @endif

    </ul>

</div>