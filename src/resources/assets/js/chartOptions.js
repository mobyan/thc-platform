import highcharts from 'highcharts';

var tempOptions = {
  chart: {
    type: 'spline', //曲线样式
    animation: highcharts.svg, // don't animate in old IE
    marginRight: 10,
  },
  title: {
    text: '温度'
  },

  xAxis: {
    type: 'datetime',
    minRange: 60 * 60 * 1000
      //minRange:60*1000
  },
  yAxis: {
    title: {
      text: '摄氏度'
    },
    plotLines: [{
      value: 0,
      width: 1,
      color: 'blue'
        //color: '#808080'
    }]
  },
  tooltip: {
    backgroundColor: '#fff',
    borderColor: 'black',
    formatter: function() { //数据提示框中单个点的格式化函数
      return '<b>' + this.series.name + '</b><br/>' +
        highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
        highcharts.numberFormat(this.y, 3); //小数后几位
    }
  },
  legend: {
    enabled: true
  },
  exporting: {
    enabled: true
  },
  series: [], //format [{name: "name", data: [[x1,y1],[x2,y2]]},{name: "name", data:[[x1,y1],[x2,y2]]}]
};

var speedOptions = {
  chart: {
    type: 'spline', //曲线样式
    animation: highcharts.svg, // don't animate in old IE
    marginRight: 10,
  },
  title: {
    text: '速度'
  },

  xAxis: {
    type: 'datetime',
    minRange: 60 * 60 * 1000
      //minRange:60*1000
  },
  yAxis: {
    title: {
      text: 'm/s'
    },
    plotLines: [{
      value: 0,
      width: 1,
      color: 'blue'
        //color: '#808080'
    }]
  },
  tooltip: {
    backgroundColor: '#fff',
    borderColor: 'black',
    formatter: function() { //数据提示框中单个点的格式化函数
      return '<b>' + this.series.name + '</b><br/>' +
        highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
        highcharts.numberFormat(this.y, 3); //小数后几位
    }
  },
  legend: {
    enabled: true
  },
  exporting: {
    enabled: true
  },
  series: [], //format [{name: "name", data: [[x1,y1],[x2,y2]]},{name: "name", data:[[x1,y1],[x2,y2]]}]
};

module.exports = {
  'temp': tempOptions,
  'speed': speedOptions,
}