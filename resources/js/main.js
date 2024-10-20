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

    // notificationIcon.addEventListener('click', function() {
    //             notificationDropdown.classList.toggle('show');
    // });

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
    
    // polling
    // Function to fetch notifications from the server
    function fetchNotifications() {
        fetch('/check-new-entries')
            .then(response => response.json())
            .then(data => {
                updateNotifications(data.newVehicles);
            })
            .catch(error => console.error('Error fetching new entries:', error));
    }

    // Initialize notifications from localStorage
    let notifications = JSON.parse(localStorage.getItem('notifications')) || [];

    // Function to update notifications in the DOM
    function updateNotifications(newVehicles) {
        const notificationList = document.getElementById('notification-list');
        const unreadCountElem = document.getElementById('notification-count');
        
        // Iterate over new notifications and check if they already exist in localStorage
        newVehicles.forEach(vehicle => {
            if (!notifications.some(notif => notif.id === vehicle.id)) {
                notifications.push({
                    id: vehicle.id,
                    plate_no: vehicle.plate_no,
                    owner_id: vehicle.vehicle_owner_id,
                    read: false // Initially set to unread
                });
            }
        });

        // Sort notifications by recency (newest on top)
        notifications.sort((a, b) => b.id - a.id);

        // Update localStorage with the new list of notifications
        localStorage.setItem('notifications', JSON.stringify(notifications));

        // Clear current list and re-render notifications
        notificationList.innerHTML = '';
        let unreadCount = 0;
        
        notifications.forEach(notif => {
            const notifElement = document.createElement('li');
            notifElement.textContent = `New vehicle with plate no. ${notif.plate_no}`;
            notifElement.dataset.id = notif.id;
            notifElement.classList.add('notification-item');
            
            // Change background color based on read/unread status
            if (notif.read) {
                notifElement.style.backgroundColor = 'lightgray';
            } else {
                notifElement.style.backgroundColor = 'lightblue';
                unreadCount++;
            }

            // Make notification clickable to redirect
            notifElement.addEventListener('click', () => {
                notif.read = true; // Mark as read when clicked
                localStorage.setItem('notifications', JSON.stringify(notifications));
                window.location.href = `/pa_details/${notif.owner_id}`;
            });

            notificationList.appendChild(notifElement);
        });

        // Update unread notification count and manage visibility of the red badge
        if (unreadCount > 0) {
            unreadCountElem.textContent = unreadCount;
            unreadCountElem.style.display = 'inline-block'; // Make the badge visible
        } else {
            unreadCountElem.style.display = 'none'; // Hide the badge when no unread notifications
        }
    }

    // Function to mark all notifications as read
    document.getElementById('mark-all-read').addEventListener('click', () => {
        notifications.forEach(notif => notif.read = true);
        localStorage.setItem('notifications', JSON.stringify(notifications));
        updateNotifications([]); // Refresh the notification list
    });

    // Initial fetch and rendering of notifications
    fetchNotifications();
    updateNotifications([]);

    // Poll every 30 seconds to check for new entries
    setInterval(fetchNotifications, 30000);

});