<!-- resources/views/layouts/main.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('storage/css/app1.css') }}"> -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    @vite(['storage/app/public/css/app1.css', 'storage/app/public/js/app.js'])
    
</head>
<body>
    <div class="container">
            <aside class="sidebar">
                <div class="logo-btn">
                    <button class="sidebar-close-btn" aria-label="Close sidebar">
                        <img src="{{ Vite::asset('storage/app/public/images/close-btn.png') }}" alt="Sidebar Close" style="width: 50px; height: 50px;">
                    </button>
                    <img src="{{ Vite::asset('storage/app/public/images/BUsina-logo-gray.png') }}" class="side-logo" alt="Description">
                </div>
                    <!-- Side menu content -->
                <ul>
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/dashboard-layout.png" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" alt="Dashboard Icon" style="width: 17px; height: 17px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('pending_applications') || request()->routeIs('pa_details') ? 'active' : '' }}">
                        <a href="{{ route('pending_applications') }}" class="{{ request()->routeIs('pending_applications') || request()->routeIs('pa_details') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/data-pending.png" class="{{ request()->routeIs('pending_applications') || request()->routeIs('pa_details') ? 'active' : '' }}" alt="Pending Applications Icon" style="width: 17px; height: 17px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Pending Applications
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('registered_vehicles') || request()->routeIs('reg_details') ? 'active' : '' }}">
                        <a href="{{ route('registered_vehicles') }}" class="{{ request()->routeIs('registered_vehicles') || request()->routeIs('reg_details') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/fiat-500.png" class="{{ request()->routeIs('registered_vehicles') || request()->routeIs('reg_details') ? 'active' : '' }}" alt="Registered Vehicles Icon" style="width: 17px; height: 17px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Registered Vehicles
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('reported_violations') || request()->routeIs('rv_details') ? 'active' : '' }}">
                        <a href="{{ route('reported_violations') }}" class="{{ request()->routeIs('reported_violations') || request()->routeIs('rv_details') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/foul.png" class="{{ request()->routeIs('reported_violations') || request()->routeIs('rv_details') ? 'active' : '' }}" alt="Reported Violations Icon" style="width: 17px; height: 17px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Reported Violations
                        </a>
                    </li>
                    <li class="payments {{ request()->routeIs('payments') ? 'active' : '' }}">
                        <a href="https://dashboard.paymongo.com/home" target="_blank" class="{{ request()->routeIs('payments') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/leaf.png" class="{{ request()->routeIs('payments') ? 'active' : '' }}" alt="Payments Icon" style="width: 17px; height: 17px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Payments
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('all_users') || request()->routeIs('au_details') ? 'active' : '' }}">
                        <a href="{{ route('all_users') }}" class="{{ request()->routeIs('all_users') || request()->routeIs('au_details') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/user.png" class="{{ request()->routeIs('all_users') || request()->routeIs('au_details') ? 'active' : '' }}" alt="All Users Icon" style="width: 17px; height: 17px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            All Users
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('guidelines') ? 'active' : '' }}">
                        <a href="{{ route('guidelines') }}" class="{{ request()->routeIs('guidelines') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/driving-guidelines.png" class="{{ request()->routeIs('guidelines') ? 'active' : '' }}" alt="Guidelines Icon" style="width: 17px; height: 17px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Guidelines
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('logout') ? 'active' : '' }}" style="margin-top: 80px;">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="{{ request()->routeIs('logout') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/open-pane.png" class="{{ request()->routeIs('logout') ? 'active' : '' }}" alt="Guidelines Icon" style="width: 17px; height: 17px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Log Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </aside>
        <div class="main-content">
            <header class="header">
                <ul>
                    <div class="hd-left">
                    <li>
                        <button class="sidebar-toggle" aria-label="Toggle sidebar">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/616779/menu.png" alt="Sidebar Toggle" style="width: 24px; height: 24px; vertical-align: middle;">
                        </button>
                    </li>
                    <li>
                        <div class="clock" id="clock"></div> <!-- Clock display -->
                    </li>
                    </div>
                    <div class="hd-right">
                    <li class="notification-icon">
                        <img src="https://img.icons8.com/sf-regular/96/616779/appointment-reminders.png" alt="Notifications" style="width: 28px; height: 28px;">
                        <div class="notification-dropdown">
                            <ul>
                                <!-- Replace with dynamic notifications -->
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="account-icon">
                        @php
                            $user = Auth::user();
                            $initials = '';

                            if ($user) {
                                $authorizedUser = $user->authorized_user; // Assuming you have a relationship set up
                                $initials = strtoupper(substr($authorizedUser->fname, 0, 1) . substr($authorizedUser->lname, 0, 1));
                            }
                        @endphp
                        <div class="user-initial-circle">
                            {{ $initials }}
                        </div>
                        <div class="account-dropdown">
                            <ul>
                                <li>
                                    <a href="{{ route('account') }}" style="display: flex; align-items: center;">
                                        <img src="https://img.icons8.com/fluency-systems-filled/96/616779/user.png" alt="My Account Icon" style="width: 17px; height: 17px; margin-right: 8px;">
                                        My Account
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="display: flex; align-items: center;">
                                        <img src="https://img.icons8.com/fluency-systems-filled/96/616779/logout-rounded-left.png" alt="Logout Icon" style="width: 17px; height: 17px; margin-right: 8px;">
                                        Log Out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                    </div>
                </ul>
            </header>
            <div>
                @yield('title-details')
            </div>
            <main class="content">
                @yield('content')
            </main>
            <main class="content">
                @yield('content-2')
            </main>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.querySelector('.sidebar-toggle');
    const closeButton = document.querySelector('.sidebar-close-btn');
    const sidebar = document.querySelector('.sidebar');
    const datetimeElement = document.getElementById('datetime');
    const notificationIcon = document.querySelector('.notification-icon');
    const accountIcon = document.querySelector('.account-icon');
    const notificationDropdown = document.querySelector('.notification-dropdown');
    const accountDropdown = document.querySelector('.account-dropdown');
    const mainContent = document.querySelector('.main-content');

    function updateClock() {
        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const now = new Date();
        const day = daysOfWeek[now.getDay()];
        const date = now.toLocaleDateString();
        const time = now.toLocaleTimeString();
        document.getElementById('clock').textContent = `${day}, ${date} - ${time}`;
    }

    toggleButton.addEventListener('click', function() {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('blur'); // Add blur when sidebar is opened
    });

    closeButton.addEventListener('click', function() {
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('blur'); // Remove blur when sidebar is closed
    });

    notificationIcon.addEventListener('click', function() {
                notificationDropdown.classList.toggle('show');
    });

    accountIcon.addEventListener('click', function() {
        accountDropdown.classList.toggle('show');
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 769) {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('blur'); // Ensure blur is removed on resize
        }
    });

    setInterval(updateClock, 1000);
    updateClock();

    document.addEventListener('click', function(event) {
        if (!notificationIcon.contains(event.target)) {
            notificationDropdown.classList.remove('show');
        }
        if (!accountIcon.contains(event.target)) {
            accountDropdown.classList.remove('show');
        }
    });
});
</script>

</body>
</html>

