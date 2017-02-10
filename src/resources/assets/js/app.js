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
    datas: []
  },
  computed: {
    charts: function() {
      return this.datas.map(function (v, k) {
        var type = ['temp', 'speed'][Math.floor(Math.random() * 10) % 2]; // fortest
        var chart = defaultOptions[type];
        chart.series = v;
        return chart;
      })
    },
    chartsx: function() {
      var charts = {};
      this.devices.forEach(function(d) {
        d.configs.forEach(function(c) {
          for (var k in c.data) {
            c.data[k].name = k;
            var type = ['temp', 'speed'][Math.floor(Math.random() * 10) % 2]; // fortest
            c.data[k].type = type;
            charts[type] = charts[type] || defaultOptions[type];
            charts[type].series.push({
              name: k,
              data: [
                [1486369987823.3499, Math.random()],
                [1486371949927.53, Math.random()],
                [1486373893430.49, Math.random()]
              ]
            })
          }
        });
      })
      return charts;
    },
  },
  watch: {

  },
  methods: {
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
$(function () {
  var requests = app.devices.map(function (v) {
    return $.get('/api/station/'+app.station.id+'/device/'+v.id+'/data');
  })
  $.when.apply($, requests).done(function (d1, d2) {
    app.datas = [formatData(d1[0].items),formatData(d2[0].items)];
  })
})