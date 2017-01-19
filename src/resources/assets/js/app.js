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

Vue.component('example', require('./components/Example.vue'));
Vue.use(VueHighcharts);

var options = {
  title: {
    text: 'Monthly Average Temperature',
    x: -20 //center
  },
  subtitle: {
    text: 'Source: WorldClimate.com',
    x: -20
  },
  xAxis: {
    type: 'datetime',
    tickInterval: 3600 * 1000,
  },
  yAxis: {
    title: {
      text: 'Temperature (°C)'
    },
    plotLines: [{
      value: 0,
      width: 1,
      color: '#808080'
    }]
  },
  tooltip: {
    valueSuffix: '°C'
  },
  legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle',
    borderWidth: 0
  },
  series: []
};

var dataKeys = [];
tplData.station.devices.forEach(function(d) {
  d.configs.forEach(function(c) {
    // console.log(Object.dataKeys(c.data));
    dataKeys = dataKeys.concat(Object.keys(c.data));
  });
})
window.app = new Vue({
  el: '#app',
  data: {
    message: 'fuck off',
    todos: [1, 2, 3, 'abc'],
    options: options,
    dataKeys: dataKeys,
    currentDataKey: dataKeys[0]
  },
  methods: {
    updateCredits: function() {
      var chart = this.$refs.highcharts.chart;
      chart.credits.update({
        style: {
          color: '#' + (Math.random() * 0xffffff | 0).toString(16)
        }
      });
    },
    selectDataKey: function (key) {
      alert('fuck');
    }
  }
});

$(function() {
  $.get('/api/station/2/device/8/data?limit=100', function(data) {
    // console.log(data)
    var d = data.items.reduce(function(memo, v) {
      if(v.data.t_10) 
        memo.push([v.ts, v.data.t_10.value]);
      return memo;
    },[])
    window.app.options.series.push({
      name: 'Beijing',
      data: d
        // data: [6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6, 10]
    });
  });
});