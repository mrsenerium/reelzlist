<!-- Navigation Bar -->
    <div class="navbar navbar-expand-lg fixed-top bg-primary" data-bs-theme="dark">
        <div class="container d-flex">
            <a class="navbar-brand" href="/">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('movies.index') }}">
                            Movie Search
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help.create') }}">
                            Help
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://blog.bootswatch.com/">
                            Blog
                        </a>
                    </li>
                </ul>
                <form class="navbar-nav ms-md-auto" method="get" action="{{ route('movies.index') }}">
                    @csrf
                        <input
                            name="q"
                            class="form-control me-sm-2"
                            type="search"
                            placeholder="Search"
                            value="{{ $q ?? request()->input('q') }}"
                        >
                        <button class="btn btn-primary my-2 my-sm-0" type="submit">
                            Search
                        </button>
                </form>
                @if (Auth::check())
                    <a href="/profile/{{auth()->user()->id}}" class="btn btn-primary">
                        {{ auth()->user()->profile->given_name }}
                    </a>
                @else
                    <a href="/login" class="nav-link">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </div>
