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

var defaultOptions = require('./chartOptions');

Vue.component('example', require('./components/Example.vue'));
Vue.use(VueHighcharts);
Vue.use(VueRouter);

const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }


const routes = [
  { path: '/foo', component: Foo },
  { path: '/bar', component: Bar }
]

const router = new VueRouter({
  routes // （缩写）相当于 routes: routes
})

var options = {
  el: '#app',
  router,
  computed: {
    charts: function() {
      var charts = {};
      this.datas.forEach(function (v) {
        // var type = ['temp', 'speed'][Math.floor(Math.random() * 10) % 2]; // fortest
        var type = v._type;
        charts[type] = charts[type] || _.cloneDeep(defaultOptions[type]);
        charts[type].series.push(v);
      })
      return charts;
    },
  },
  watch: {
    selectedDevice: function () {
      this.loadDeviceData(this.devices[this.selectedDevice])
    }
  },
  methods: {
    loadDeviceData: function (device) {
      var app = this;
      $.get('/api/station/'+this.station.id+'/device/'+device.id+'/data', function (data) {
        app.datas = formatData(data.items, device.config);
      });
    }
  }
};
function formatData(items, config) {
  var data = {};
  items.forEach(function (v) {
    _.forIn(v.data, function (value, key) {
      data[key] = data[key] || [];
      data[key].push([new Date(v.ts).getTime(), value.value]);
    })
  })
  return _.map(data, function (v, k) {
    return {
      name: k,
      data: v,
      _type: config.data[k] ? config.data[k].type : 'temp',
    }
  })
}

$(function () {
  $.get('/api/station/2?with=devices.configs', function (station) {
    station.devices = _.map(station.devices, function (v) {
      v.config = _.last(v.configs);
      return v;
    })
    options.data = {
      devices: station.devices,
      station: station,
      selectedDevice: 0,
      datas: [],
    },
    window.app = new Vue(options);
  })
})