import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/app1.css',
                'resources/css/details.css',
                'resources/css/email_style.css',
                'resources/css/guidelines.css',
                'resources/css/login.css',
                'resources/css/pending-applications.css',

                'resources/images/busina_asset.png',
                'resources/images/BUsina-logo-gray.png',
                'resources/images/close-btn.png',
                'resources/images/lockreload.png',
                'resources/images/login.png',
                'resources/images/mail-check.png',
                'resources/images/password.png',
                'resources/images/upload 1.png',

                'resources/js/app.js',
                'resources/js/main.js',
                'resources/js/bootstrap.js',
                'resources/js/disableForm.js',
                'resources/js/hide_error_message.js',
                'resources/js/login_toggle_password.js',
                'resources/js/reset_new_pass.js',
                'resources/js/dashboard.js',
                'resources/js/notifs.js'
            ],
            refresh: true,
        }),
    ],
});
