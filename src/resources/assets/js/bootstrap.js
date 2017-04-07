
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
window.moment = require('moment');

require('bootstrap-sass');


/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
require('vue-resource');
window.Cookie = require('js-cookie');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
});

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-APP-ID', Cookie.get('currentApp'));
    next();
});

Vue.http.interceptors.push((request, next) => {
    window.app.loading = true;
    next(()=> {
    window.app.loading = false;
    });
});

Object.assign = Object.assign || _.assign

function tips(type, msg) {
    $('.alert-'+type).text(msg).fadeTo(1000, 1).slideUp(2000, function() {
        $("#alert").slideUp(500);
    });
}

Vue.http.interceptors.push((request, next) => {
    var alert = request.params.alert;
    delete request.params.alert;
    next((response)=> {
        if (alert) {
            var type = response.ok ? 'success': 'warning';
            tips(type, alert + (response.ok ? '成功' : '失败'));
        }
        if (response.status == 403) {
            tips('warning', '权限不足')
        }
    });
});
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
