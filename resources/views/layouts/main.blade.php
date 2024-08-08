<!-- resources/views/layouts/main.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    
</head>
<body>
    <div class="container">
        
            <aside class="sidebar">
                <div class="logo-btn">
                    <button class="sidebar-close-btn" aria-label="Close sidebar">
                        <img src="https://img.icons8.com/fluency-systems-filled/96/616779/menu.png" alt="Sidebar Close" style="width: 24px; height: 24px;">
                    </button>
                    <img src="{{ asset('storage/images/BUsina-logo-gray.png') }}" class="side-logo" alt="Description">
                </div>
                    <!-- Side menu content -->
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/dashboard-layout.png" alt="Dashboard Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pending_applications') }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/data-pending.png" alt="Pending Applications Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Pending Applications
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('registered_vehicles') }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/fiat-500.png" alt="Registered Vehicles Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Registered Vehicles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reported_violations') }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/foul.png" alt="Reported Violations Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            Reported Violations
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('all_users') }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/user.png" alt="All Users Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
                            All Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guidelines') }}">
                            <img src="https://img.icons8.com/fluency-systems-filled/96/697a8d/driving-guidelines.png" alt="Guidelines Icon" style="width: 19px; height: 19px; vertical-align: middle; margin-right: 8px; margin-left: 8px;">
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
            <main class="content">
                <h1>HELLO WORLD!</h1>
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('.sidebar-toggle');
            const closeButton = document.querySelector('.sidebar-close-btn');
            const sidebar = document.querySelector('.sidebar');
            const datetimeElement = document.getElementById('datetime');

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
            });

            closeButton.addEventListener('click', function() {
                sidebar.classList.remove('collapsed');
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 769) {
                    sidebar.classList.remove('collapsed');
                }
            });
            setInterval(updateClock, 1000);
            updateClock();
        });
    </script>
</body>
</html>

