<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">

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
                            {{ Auth::user()->name }}
                            @if ( Auth::user()->avatar )
                                <img class="avatar rounded-pill" src="{{ url('/storage/images/' . Auth::user()->avatar) }}" width="36" height="36">
                            @endif
                            <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('my') }}">
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
