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
var defaultOptions = require('./chartOptions');

Vue.component('example', require('./components/Example.vue'));
Vue.use(VueHighcharts);

window.app = new Vue({
  el: '#app',
  data: {
    devices: tplData.station.devices,
    station: tplData.station,
    selectedDevice: 0,
    datas: [],
  },
  computed: {
    charts: function() {
      var charts = {};
      this.datas.forEach(function (v) {
        var type = ['temp', 'speed'][Math.floor(Math.random() * 10) % 2]; // fortest
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
        app.datas = formatData(data.items);
      });
    }
  }
});
function formatData(items) {
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
    }
  })
}
// $(function () {
//   var requests = app.devices.map(function (v) {
//     return $.get('/api/station/'+app.station.id+'/device/'+v.id+'/data');
//   })
//   $.when.apply($, requests).done(function (d1, d2) {
//     app.datas = [formatData(d1[0].items),formatData(d2[0].items)];
//   })
// })