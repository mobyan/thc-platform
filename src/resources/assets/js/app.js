/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import VueHighcharts from 'vue-highcharts';
import highcharts from 'highcharts';
import VueRouter from 'vue-router'
import dashboard from './components/dashboard.vue'
import stations from './components/stations.vue'
import station from './components/station.vue'

Vue.component('example', require('./components/Example.vue'));
Vue.use(VueHighcharts);
Vue.use(VueRouter);

const routes = [
  { path: '/station/:station', component: station},
  { path: '/station/:station/dashboard', component: dashboard},
  { path: '/station', component: stations},
]

const router = new VueRouter({
  routes
})

window.app = new Vue({
  el: '#app',
  router
})