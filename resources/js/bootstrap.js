import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'a36ac8ab6526ea3e34ad',
    cluster: 'ap1',
    encrypted: true, // Set to true if using SSL
});
