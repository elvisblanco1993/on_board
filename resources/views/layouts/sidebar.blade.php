<div class="col-md-2">

    <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

        @if (isset($role) && $role->contains('admin') || isset($role) && $role->contains('advisor'))
            <a href="{{ url('dashboard') }}" class="nav-link {{ Route::current()->getName() == 'dashboard' ? 'active' : '' }}">
                <i class="fas fa-home mr-2"></i>
                Home
            </a>

            <a href="{{ url('users') }}" class="nav-link {{ strpos(Route::current()->getName(), 'user') !== FALSE ? 'active' : '' }}">
                <i class="fas fa-user-friends mr-2"></i>
                Users
            </a>
        @endif

        @if (isset($role) && $role->contains('admin'))
            <a href="{{ url('settings') }}" class="nav-link {{ Route::current()->getName() == 'settings' ? 'active' : '' }}">
                <i class="fas fa-cog mr-2"></i>
                Settings
            </a>
        @endif

    </ul>

</div>
