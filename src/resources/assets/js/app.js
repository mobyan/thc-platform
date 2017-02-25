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
import routes from './routes'
import AMap from 'vue-amap';
Vue.use(AMap);

AMap.initAMapApiLoader({
  key: '5d7513412b713a3d6daf2fa69bc31c6e',
  plugin: ['AMap.Autocomplete', 'AMap.PlaceSearch', 'AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MapType', 'AMap.PolyEditor', 'AMap.CircleEditor']
});

Vue.component('example', require('./components/Example.vue'));
Vue.component('gallery', require('./components/gallery.vue'));
Vue.use(VueHighcharts);
Vue.use(VueRouter);

const router = new VueRouter({
  routes
})

window.app = new Vue({
  el: '#app',
  router
})
