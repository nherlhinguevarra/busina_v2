import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'a36ac8ab6526ea3e34ad',
    cluster: 'ap1',
    encrypted: true, // Set to true if using SSL
});

    
    // Initialize notification count
    let notificationCount = 0;

    // Listen for VehicleAdded event
    window.Echo.channel('vehicles')
    .listen('VehicleAdded', (event) => {
        // Display notification in the list
        const notificationList = document.getElementById('notification-list');
        const notificationItem = document.createElement('li');
        notificationItem.classList.add('notification-item');
        notificationItem.innerHTML = `
            <a href="${event.url}" class="notification-link">
                New Vehicle Added: Plate No. ${event.plate_no}
            </a>
        `;
        notificationList.appendChild(notificationItem);

        // Increment the notification count
        const notificationCount = document.getElementById('notification-count');
        let count = parseInt(notificationCount.textContent) || 0;
        notificationCount.textContent = count + 1;
    });



    // Listen for ViolationAdded event
    window.Echo.channel('violations')
    .listen('ViolationAdded', (event) => {
        // Display notification in the list
        const notificationList = document.getElementById('notification-list');
        const notificationItem = document.createElement('li');
        notificationItem.classList.add('notification-item');
        notificationItem.innerHTML = `
            <a href="${event.url}" class="notification-link">
                New Violation Added: Plate No. ${event.plate_no}
            </a>
        `;
        notificationList.appendChild(notificationItem);

        // Increment the notification count
        const notificationCount = document.getElementById('notification-count');
        let count = parseInt(notificationCount.textContent) || 0;
        notificationCount.textContent = count + 1;
    });


    // Event listener for "Mark all as read"
    document.getElementById('mark-all-read').addEventListener('click', () => {
        const notificationList = document.getElementById('notification-list');
        notificationList.innerHTML = '';  // Clear all notifications
    
        // Reset notification count
        document.getElementById('notification-count').textContent = 0;
    });
     

    // Event delegation for delete buttons
    document.getElementById('notification-list').addEventListener('click', (event) => {
        if (event.target.classList.contains('delete-notification')) {
            const listItem = event.target.closest('li');
            listItem.remove();
            notificationCount--;
            document.getElementById('notification-count').textContent = notificationCount;
        }
    });
