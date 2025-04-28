<div class="header">
    <div class="container">
        <div class="row">
            <!-- Logo Section -->
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                <div class="full">
                    <div class="center-desk">
                        <div class="logo">
                            <a href="{{url('/') }}">
                                <img src="images/logo.png" alt="Logo" class="logo-circle" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Bar Section -->
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                <nav class="navigation navbar navbar-expand-md navbar-dark">
                    <!-- Toggle button for mobile view -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav mr-auto">
                            <!-- Home Link -->
                            <li class="nav-item active">
                                <a class="nav-link" href="{{url('/') }}">Home</a>
                            </li>

                            <!-- Our Room Link (hidden for staff users) -->
                            @if(!Auth::check() || (Auth::check() && Auth::user()->usertype != 'staff'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('rooms.show_room') }}">Our Room</a>
                                </li>
                            @endif
                            
                            <!-- Order Foods Link (visible only for authenticated users, not staff) -->
                            @auth
                                @if(Auth::user()->usertype != 'staff')
                                    <li class="nav-item">
                                        <a href="{{ route('food.view') }}" class="nav-link">Foods</a>
                                    </li>
                                @endif
                            @endauth

                            <!-- Contact Us Link (hidden for staff users) -->
                            @if(Auth::check() && Auth::user()->usertype != 'staff')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('contact-us') }}">Contact Us</a>
                                </li>
                            @endif

                            <!-- Dashboard Link (visible only for staff users) -->
                            @if(Auth::check() && Auth::user()->usertype == 'staff')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('admin/dashboard') }}">Dashboard</a>
                                </li>
                            @endif

                            <!-- Auth Links (Login/Logout/Register) -->
                            @guest
                                <!-- Login Button -->
                                <li class="nav-item">
                                    <a class="btn btn-success mx-2 my-1" href="{{ url('login') }}">Login</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="btn btn-primary mx-2 my-1" href="{{ url('register') }}">Register</a>
                                    </li>
                                @endif
                            @endguest

                            @auth
                                <!-- User Profile Link -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('profile.show') }}">
                                        {{ Auth::user()->name }}
                                    </a>
                                </li>
                                <!-- Logout Button -->
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LogOut</a>
                                </li>
                                <!-- Logout Form -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endauth
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Logo -->
<style>
    .logo-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Include Bootstrap JS (for the collapsible navbar) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
