window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
window.Swal = swal = require('sweetalert2');
window.izitoast = iziToast = require('izitoast');

try {
    require('bootstrap');
    require('admin-lte');
    require('datatables.net-bs4');
    require('@fortawesome/fontawesome-free/js/all.min.js');
    require('jquery-validation');
    require('bootstrap4-toggle');
    require('select2');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
