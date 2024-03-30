<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="{{ asset('public.img.logo.png') }}" alt="Логотип">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ @route('home') }}">Новости</a>
            </li>
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ @route('auth') }}">Вход</a>
                </li>
            @endguest
            @auth
                @if (auth()->user()->role === 1)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ @route('usrRedaction') }}">Администрирование</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ @route('user') }}">Личный кабинет</a>
                </li>
                <li class="nav-item">
                    <form action="{{ @route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link bg-dark border-0 " href="#">Выход</button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</nav>
