<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <title>Dashboard</title>
</head>
<body>
    <nav>
        <div class="logo-name">
         <div class="logo-image">
            <a href="{{ url('/admin/dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-circle" />
            </a>
         </div>
        </div>

        <div class="menu-items">
        <ul class="nav-links">
            <li>
                <a href="{{ url('/dashboardview') }}">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a>
            </li>
            @if(Auth::check() && Auth::user()->usertype == 'admin')
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="uil uil-house-user"></i>
                    <span class="link-name">Rooms</span>
                    <i class="uil uil-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('admin/add_room')}}">Add Room</a></li>
                    <li><a href="{{url('view_room')}}">View Room</a></li>
                    <li><a href="{{ route('admin.bookedrooms') }}">Booked Rooms</a></li>
                    <li><a href="{{ route('admin.approvedBookings') }}">Approved Bookings</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="uil uil-map-marker"></i> 
                    <span class="link-name">Aboutus</span>
                    <i class="uil uil-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('aboutus')}}">Add Aboutus</a></li>
                </ul>
            </li>
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="uil uil-image"></i>
                    <span class="link-name">Banners</span>
                    <i class="uil uil-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('banners.index') }}">View Banners</a></li>
                    <li><a href="{{ url('/banners/add') }}">Add Banners</a></li>
                </ul>
             </li>
             <li class="dropdown">
            <a href="#" class="dropdown-toggle">
                <i class="uil uil-phone"></i>
                <span class="link-name">Contact</span>
                <i class="uil uil-angle-down"></i>
            </a>
            
            <ul class="dropdown-menu">
            <li><a href="{{ route('admin.contacts.index') }}">Contact Us Details</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle">
                <i class="uil uil-plus"></i>
                <span class="link-name">Staff</span>
                <i class="uil uil-angle-down"></i>
            </a>
            <ul class="dropdown-menu">
            <li><a href="{{ route('admin.registerStaffForm') }}" class="btn btn-primary">Register Staff</a></li>
            <li><a href="{{ route('staff.users') }}" class="btn btn-primary">View Staffs</a></li>
        </ul>
        </li>
        </ul>
            @endif
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="uil uil-utensils"></i>
                    <span class="link-name">Food</span>
                    <i class="uil uil-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    @if(Auth::check() && Auth::user()->usertype == 'admin')
                        <li><a href="{{ route('admin.food.create') }}">Add Food</a></li>
                        <li><a href="{{ route('admin.food.index') }}">View Food</a></li>
                    @endif
                    <li><a href="{{ route('admin.food.orders') }}">Pending Orders</a></li>
                    <li><a href="{{ route('admin.food.completed.orders') }}">Completed Orders</a></li>
                </ul>
            </li>
            
        <ul class="logout-mode">
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: none;" id="logout-form">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">{{ __('Log Out') }}</span>
                </a>
            </li>

            <li class="mode">
                <a href="#">
                    <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>
                <div class="mode-toggle">
                    <span class="switch"></span>
                </div>
            </li>
        </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
        </div>

        <div class="dash-content">
           @yield('content')
        </div>
    </section>
    <script src="{{ asset('js/admin.js') }}"></script>

</body>
</html>
<div class="col-md-10 mt-4 image">
    @if(isset($about))
    <img src="{{ asset('uploads/aboutus/' . $about->image) }}" alt="" style="width: 100px; height: 100px;" class="mt-2">
    @endif
</div>
