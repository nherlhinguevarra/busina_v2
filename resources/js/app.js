import './bootstrap';

window.Echo.channel('vehicle-channel')
    .listen('NewVehicleNotif', (event) => {
        console.log('New vehicle added:', event.vehicle);
    });

window.Echo.channel('violation-channel')
    .listen('NewViolationNotif', (event) => {
        console.log('New violation added:', event.violation);
    });
