<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">

        @auth
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <img
                    src="{{ url('/storage/images/logo.png') }}"
                    height="30"
                    loading="lazy"
                    alt="{{ config('app.name') }}">
            </a>
        @else
            <a class="navbar-brand" href="{{ url('/') }}">
                <img
                    src="{{ url('/storage/images/logo.png') }}"
                    height="30"
                    loading="lazy"
                    alt="{{ config('app.name') }}">
            </a>
        @endauth

        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- Right Side Of Navbar --}}
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('SIGN IN') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('GET STARTED') }}</a>
                        </li>
                    @endif
                @else

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if ( Auth::user()->avatar )
                            <img class="avatar rounded-pill" src="{{ url('/storage/images/' . Auth::user()->avatar) }}" width="36" height="36">
                            @endif
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('my') }}">
                                <i class="fas fa-user-alt text-secondary"></i>
                                {{ __('Profile') }}
                            </a>

                            @if ( Auth::user()->roles[0]->pivot->role_id == 3 )
                                <a role="button" class="dropdown-item" data-toggle="modal" data-target="#support">
                                    <i class="fas fa-life-ring text-secondary"></i>
                                    {{ __('Support') }}
                                </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt text-danger"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>

                    {{-- Support Modal --}}
                    @if ( Auth::user()->roles[0]->pivot->role_id == 3 )
                    <div class="modal fade" id="support" tabindex="-1" role="dialog" aria-labelledby="supportLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="supportLabel">Support</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <div class="media">
                                            <a class="d-flex" href="#">
                                                <img src="" alt="">
                                            </a>
                                            <div class="media-body">
                                                <p>We are here to assist you with any questions or difficulties you may encounter. Please use one of the contact options below to request support.</p>
                                                @if ( ! is_null( App\Settings::first()->phone ) )
                                                    <p>
                                                        <i class="fas fa-phone-alt mr-2"></i>
                                                        <a href="tel:{{ App\Settings::first()->phone }}">{{ App\Settings::first()->phone }}</a>
                                                    </p>
                                                @endif

                                                @if ( ! is_null( App\Settings::first()->email ) )
                                                    <p>
                                                        <i class="fas fa-envelope mr-2"></i>
                                                        <a href="mailto:{{ App\Settings::first()->email }}">{{ App\Settings::first()->email }}</a>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>
