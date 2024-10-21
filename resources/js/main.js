document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const toggleButton = document.querySelector('.sidebar-toggle');
    const closeButton = document.querySelector('.sidebar-close-btn');
    const sidebar = document.querySelector('.sidebar');
    const datetimeElement = document.getElementById('datetime');
    const notificationIcon = document.querySelector('.notification-icon');
    const accountIcon = document.querySelector('.account-icon');
    const notificationDropdown = document.querySelector('.notification-dropdown');
    const accountDropdown = document.querySelector('.account-dropdown');
    const mainContent = document.querySelector('.main-content');

    // Clock update function
    function updateClock() {
        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const now = new Date();
        const day = daysOfWeek[now.getDay()];
        const date = now.toLocaleDateString();
        const time = now.toLocaleTimeString();
        document.getElementById('clock').textContent = `${day}, ${date} - ${time}`;
    }

    // Sidebar event listeners
    toggleButton.addEventListener('click', function() {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('blur');
    });

    closeButton.addEventListener('click', function() {
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('blur');
    });

    // Dropdown toggles
    notificationIcon.addEventListener('click', function() {
        notificationDropdown.classList.toggle('show');
    });

    accountIcon.addEventListener('click', function() {
        accountDropdown.classList.toggle('show');
    });

    // Responsive handling
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 769) {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('blur');
        }
    });

    // Initialize clock
    setInterval(updateClock, 1000);
    updateClock();

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!notificationIcon.contains(event.target)) {
            notificationDropdown.classList.remove('show');
        }
        if (!accountIcon.contains(event.target)) {
            accountDropdown.classList.remove('show');
        }
    });

    // Initialize notifications from localStorage
    let notifications = JSON.parse(localStorage.getItem('notifications')) || [];

    // Fetch notifications from server
    async function fetchNotifications() {
        try {
            const response = await fetch('/check-new-entries');
            const data = await response.json();
            updateNotifications(data.newVehicles, data.newViolations);
        } catch (error) {
            console.error('Error fetching new entries:', error);
            showToast('Failed to fetch notifications', 'error');
        }
    }

    // Update and render notifications
    function updateNotifications(newVehicles = [], newViolations = []) {
        const notificationList = document.getElementById('notification-list');
        const unreadCountElem = document.getElementById('notification-count');
        let unreadCount = 0;

        // Process new vehicles
        newVehicles.forEach(vehicle => {
            if (!notifications.some(notif => notif.id === vehicle.id && notif.type === 'vehicle')) {
                notifications.push({
                    id: vehicle.id,
                    plate_no: vehicle.plate_no,
                    owner_id: vehicle.vehicle_owner_id,
                    type: 'vehicle',
                    read: false,
                    timestamp: new Date().toISOString()
                });
            }
        });

        // Process new violations
        newViolations.forEach(violation => {
            if (!notifications.some(notif => notif.id === violation.id && notif.type === 'violation')) {
                notifications.push({
                    id: violation.id,
                    violation_name: violation.violation_name,
                    owner_id: violation.vehicle_owner_id,
                    type: 'violation',
                    read: false,
                    timestamp: new Date().toISOString()
                });
            }
        });

        // Sort notifications by timestamp (newest first)
        notifications.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

        // Update localStorage
        localStorage.setItem('notifications', JSON.stringify(notifications));

        // Clear and render notification list
        notificationList.innerHTML = '';
        
        if (notifications.length === 0) {
            const emptyMessage = document.createElement('li');
            emptyMessage.classList.add('notification-empty');
            emptyMessage.textContent = 'No notifications';
            notificationList.appendChild(emptyMessage);
        } else {
            notifications.forEach(notif => {
                const notifElement = document.createElement('li');
                notifElement.classList.add('notification-item');
                notifElement.dataset.id = notif.id;
                notifElement.dataset.type = notif.type;

                // Create notification content
                const contentDiv = document.createElement('div');
                contentDiv.classList.add('notification-content');
                
                // Add icon based on type
                const icon = document.createElement('span');
                icon.classList.add('notification-icon');
                icon.innerHTML = notif.type === 'vehicle' ? '🚗' : '⚠️';
                contentDiv.appendChild(icon);

                // Add message
                const message = document.createElement('span');
                message.classList.add('notification-message');
                message.textContent = notif.type === 'vehicle' 
                    ? `New vehicle with plate no. ${notif.plate_no}`
                    : `New violation: ${notif.violation_name}`;
                contentDiv.appendChild(message);

                // Add timestamp
                const time = document.createElement('span');
                time.classList.add('notification-time');
                time.textContent = new Date(notif.timestamp).toLocaleString();
                contentDiv.appendChild(time);

                notifElement.appendChild(contentDiv);

                // Set background color based on read status
                notifElement.style.backgroundColor = notif.read ? '#f0f0f0' : 'rgba(53, 192, 247, 0.3)';
                if (!notif.read) unreadCount++;

                // Add click handler for notification
                notifElement.addEventListener('click', () => {
                    notif.read = true;
                    localStorage.setItem('notifications', JSON.stringify(notifications));
                    window.location.href = `/pa_details/${notif.owner_id}`;
                });

                // Add delete button
                const deleteButton = document.createElement('button');
                deleteButton.textContent = '×';
                deleteButton.classList.add('delete-btn');
                deleteButton.title = 'Delete notification';
                deleteButton.addEventListener('click', async (event) => {
                    await deleteNotification(notif.id, notif.type, event);
                });
                notifElement.appendChild(deleteButton);

                notificationList.appendChild(notifElement);
            });
        }

        // Update unread count badge
        if (unreadCount > 0) {
            unreadCountElem.textContent = unreadCount;
            unreadCountElem.style.display = 'inline-block';
        } else {
            unreadCountElem.style.display = 'none';
        }
    }

    // Delete notification function
    async function deleteNotification(id, type, event) {
        event.stopPropagation();

        try {
            const response = await fetch('/api/notifications/delete', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    // Add CSRF token if needed
                    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    notification_id: id,
                    notification_type: type
                })
            });

            if (!response.ok) {
                throw new Error('Failed to delete notification');
            }

            // Remove from local storage
            notifications = notifications.filter(notif => !(notif.id === id && notif.type === type));
            localStorage.setItem('notifications', JSON.stringify(notifications));
            
            // Animate removal
            const notificationElement = event.target.parentElement;
            notificationElement.style.transition = 'opacity 0.3s ease-out';
            notificationElement.style.opacity = '0';
            
            setTimeout(() => {
                updateNotifications();
            }, 300);

            showToast('Notification deleted successfully');

        } catch (error) {
            console.error('Error deleting notification:', error);
            showToast('Failed to delete notification', 'error');
        }
    }

    // Mark all as read function
    async function markAllAsRead() {
        try {
            const response = await fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Add CSRF token if needed
                }
            });

            if (!response.ok) {
                throw new Error('Failed to mark notifications as read');
            }

            notifications.forEach(notif => notif.read = true);
            localStorage.setItem('notifications', JSON.stringify(notifications));
            updateNotifications();
            showToast('All notifications marked as read');

        } catch (error) {
            console.error('Error marking notifications as read:', error);
            showToast('Failed to mark notifications as read', 'error');
        }
    }

    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.classList.add('toast', `toast-${type}`);
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Trigger animation
        setTimeout(() => toast.classList.add('show'), 10);
        
        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Add styles
    const style = document.createElement('style');
    style.textContent = `
        .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .notification-content {
            flex-grow: 1;
            margin-right: 12px;
        }

        .notification-icon {
            margin-right: 8px;
        }

        .notification-message {
            font-size: 14px;
        }

        .notification-time {
            display: block;
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }

        .notification-empty {
            padding: 16px;
            text-align: center;
            color: #666;
        }

        .delete-btn {
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            background-color: #f44336;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.2s;
            line-height: 1;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 24px;
            border-radius: 4px;
            color: white;
            opacity: 0;
            transform: translateY(100%);
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }
        
        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .toast-success {
            background-color: #4CAF50;
        }
        
        .toast-error {
            background-color: #f44336;
        }
    `;
    document.head.appendChild(style);

    // Add event listener for "Mark all as read" button
    document.getElementById('mark-all-read').addEventListener('click', markAllAsRead);

    // Initial fetch and update
    fetchNotifications();
    updateNotifications();

    // Poll for new notifications every 30 seconds
    setInterval(fetchNotifications, 30000);
});

//DELETE AND MARK ALL AS READ NOT WORKING