<div class="col-md-2">

    <ul class="nav flex-column">

        @if (isset($role) && $role->contains('admin') || isset($role) && $role->contains('advisor'))
        <li class="nav-item">
            <a href="{{ url('dashboard') }}" class="nav-link" style="color: {{ Route::current()->getName() == 'dashboard' ? '#3273dc' : '#2a5164' }}">
                <i class="fas fa-home mr-2" style="color: {{ Route::current()->getName() == 'dashboard' ? '#3273dc' : '#c3cbd3' }}"></i>
                Home
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
            <a href="{{ url('documents') }}" class="nav-link" style="color: {{ Route::current()->getName() == 'documents' ? '#3273dc' : '#2a5164' }}">
                <i class="fas fa-folder-open mr-2" style="color: {{ Route::current()->getName() == 'documents' ? '#3273dc' : '#c3cbd3' }}"></i>
                Documents
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('settings') }}" class="nav-link" style="color: {{ Route::current()->getName() == 'settings' ? '#3273dc' : '#2a5164' }}">
                <i class="fas fa-cog mr-2" style="color: {{ Route::current()->getName() == 'settings' ? '#3273dc' : '#c3cbd3' }}"></i>
                Settings
            </a>
            <ul class="nav flex-column ml-4 pl-1">
                <li class="nav-item mb-0">
                    <a href="{{ url('settings/company') }}" class="nav-link" style="color: {{ Route::current()->getName() == 'company' ? '#3273dc' : '#2a5164' }}">
                        <i class="fas fa-business-time mr-2" style="color: {{ Route::current()->getName() == 'company' ? '#3273dc' : '#c3cbd3' }}"></i>
                        Institution
                    </a>
                </li>
                <li class="nav-item mb-0">
                    <a href="{{ url('settings/frontpage') }}" class="nav-link" style="color: {{ Route::current()->getName() == 'frontpage' ? '#3273dc' : '#2a5164' }}">
                        <i class="fas fa-laptop-code mr-2" style="color: {{ Route::current()->getName() == 'frontpage' ? '#3273dc' : '#c3cbd3' }}"></i>
                        Front page
                    </a>
                </li>
            </ul>
        </li>
        @endif

    </ul>

</div>
