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


var demoDatas = [{"name":"空气温度","data":[[1486369987823.3499,7.5043869687953],[1486371949927.53,7.13206683451591],[1486373893430.49,6.79026474402991],[1486375842179.3398,6.32028686961166],[1486377805181.4001,6.14633401998931],[1486379754081.39,5.95712214847028],[1486381702554.96,5.81979095140001],[1486383664336.89,5.54818036163881]]},{"name":"土壤温度 10cm","data":[[1486369987831.98,6.86770428015564],[1486371949936.1301,6.88677805752651],[1486373893439.17,6.85626001373312],[1486375842187.9302,6.88677805752651],[1486377805190.25,6.91538872358282],[1486379754089.89,6.9325551232166],[1486381702563.81,6.92111085679408],[1486383664345.74,6.93446250095369]]},{"name":"土壤温度 30cm","data":[[1486369987840.53,5.59548332951858],[1486371949944.61,5.57640955214771],[1486373893447.6199,5.48294804303044],[1486375842196.5498,5.58594644083314],[1486377805198.6,5.61074235141528],[1486379754098.2102,5.57068741893644],[1486381702572.46,5.58976119630731],[1486383664354.31,5.58213168535897]]}];

var options = {
        chart: {
                type: 'spline',                      //曲线样式
                animation: highcharts.svg, // don't animate in old IE
                marginRight: 10,
            },
            title:{
                text:'xxx'
            },

            xAxis: {
                type: 'datetime',
                minRange:60*60*1000
                //minRange:60*1000
            },
            yAxis: {
                title: {
                    text: 'yyy'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color:'blue'
                    //color: '#808080'
                }]
            },
            tooltip: {
                backgroundColor:'#fff',
                borderColor:'black',
                formatter: function () {        //数据提示框中单个点的格式化函数
                    return '<b>' + this.series.name+ '</b><br/>' +
                        highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                        highcharts.numberFormat(this.y, 3);   //小数后几位
                }
            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: true
            },
            series: demoDatas,
            // series: [],//format [{name: "name", data: [[x1,y1],[x2,y2]]},{name: "name", data:[[x1,y1],[x2,y2]]}]
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
    currentDataKey: dataKeys[0],
    devices: tplData.station.devices,
    checkedKeys: [],
  },
  computed: {

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
      // alert('fuck');
      // render_chart(demoDatas, 'xx', 'yy', 'xx', 'spline', 'demo');
      var demoData = demoDatas[Math.floor(Math.random()*demoDatas.length)];
      this.options.series = [demoData];
    }
  }
});
