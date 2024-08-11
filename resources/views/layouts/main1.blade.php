<!-- resources/views/layouts/main.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/css/app1.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    
</head>
<body>
    <div class="container">
            <aside class="sidebar">
                <div class="logo-btn">
                    <button class="sidebar-close-btn" aria-label="Close sidebar">
                        <img src="{{ asset('storage/images/close-btn.png') }}" alt="Sidebar Close" style="width: 50px; height: 50px;">
                    </button>
                    <img src="{{ asset('storage/images/BUsina-logo-gray.png') }}" class="side-logo" alt="Description">
                </div>
                    <!-- Side menu content -->
                <ul>
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/dashboard-layout.png" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" alt="Dashboard Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('pending_applications') ? 'active' : '' }}">
                        <a href="{{ route('pending_applications') }}" class="{{ request()->routeIs('pending_applications') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/data-pending.png" class="{{ request()->routeIs('pending_applications') ? 'active' : '' }}" alt="Pending Applications Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Pending Applications
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('registered_vehicles') ? 'active' : '' }}">
                        <a href="{{ route('registered_vehicles') }}" class="{{ request()->routeIs('registered_vehicles') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/fiat-500.png" class="{{ request()->routeIs('registered_vehicles') ? 'active' : '' }}" alt="Registered Vehicles Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Registered Vehicles
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('reported_violations') ? 'active' : '' }}">
                        <a href="{{ route('reported_violations') }}" class="{{ request()->routeIs('reported_violations') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/foul.png" class="{{ request()->routeIs('reported_violations') ? 'active' : '' }}" alt="Reported Violations Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Reported Violations
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('all_users') ? 'active' : '' }}">
                        <a href="{{ route('all_users') }}" class="{{ request()->routeIs('all_users') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/user.png" class="{{ request()->routeIs('all_users') ? 'active' : '' }}" alt="All Users Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            All Users
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('guidelines') ? 'active' : '' }}">
                        <a href="{{ route('guidelines') }}" class="{{ request()->routeIs('guidelines') ? 'active' : '' }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/driving-guidelines.png" class="{{ request()->routeIs('guidelines') ? 'active' : '' }}" alt="Guidelines Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Guidelines
                        </a>
                    </li>
                </ul>
            </aside>
        <div class="main-content">
            <header class="header">
                <ul>
                    <li>
                        <button class="sidebar-toggle" aria-label="Toggle sidebar">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/616779/menu.png" alt="Sidebar Toggle" style="width: 24px; height: 24px; vertical-align: middle;">
                        </button>
                    </li>
                    <li>
                        <div class="clock" id="clock"></div> <!-- Clock display -->
                    </li>
                </ul>
            </header>
            <div>
                @yield('title-details')
            </div>
            <div class="grid-container">
            <div class="top-left">
                @yield('content')
            </div>
            <div class="top-right">
                @yield('content-2')
            </div>
            <div class="bottom">
                @yield('content-3')
            </div>
    </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.querySelector('.sidebar-toggle');
    const closeButton = document.querySelector('.sidebar-close-btn');
    const sidebar = document.querySelector('.sidebar');
    const datetimeElement = document.getElementById('datetime');
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

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 769) {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('blur'); // Ensure blur is removed on resize
        }
    });

    setInterval(updateClock, 1000);
    updateClock();
});
</script>

</body>
</html>

