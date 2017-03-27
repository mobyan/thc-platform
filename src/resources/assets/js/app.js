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
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

Vue.use(AMap);

AMap.initAMapApiLoader({
  key: '5d7513412b713a3d6daf2fa69bc31c6e',
  plugin: ['AMap.Autocomplete', 'AMap.PlaceSearch', 'AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MapType', 'AMap.PolyEditor', 'AMap.CircleEditor']
});

highcharts.setOptions({
  global: {
    useUTC: false
  }
});

Vue.component('example', require('./components/Example.vue'));
Vue.component('gallery', require('./components/gallery.vue'));
Vue.component('viewer', require('./components/viewer.vue'));
Vue.use(VueHighcharts);
Vue.use(VueRouter);

const router = new VueRouter({
  // mode: 'history',
  routes
})

window.thc.can = function(permission_name) {
  for (var r in thc.user.roles) {
    var role = thc.user.roles[r]
    for (var p in role.permissions) {
      var permission = role.permissions[p]
      if (permission.name == permission_name) {
        return true;
      }
    }
  }
  return false;
}

window.app = new Vue({
  el: '#app',
  data: {
    loading: false,
    user: null,
  },
  methods: {
    isAdmin: function () {
      console.log(thc.can('sys_w'))
      return thc.can('sys_w');
    }
  },
  components: {
    PulseLoader
  },
  router,
  created: function() {
    if (!thc.can('app_r') || thc.user.apps.length == 0) {
      this.$router.push('apply');
    }
  }
})