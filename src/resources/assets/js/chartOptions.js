import highcharts from 'highcharts';
var _ = require('lodash');;
var defaultOption = {
    chart: {
        type: 'spline', //曲线样式
        animation: highcharts.svg, // don't animate in old IE
        marginRight: 10,
        zoomType: 'x'
    },
    title: {
        text: '温度'
    },

    xAxis: {
        type: 'datetime',
        minRange: 24 * 60 * 60 * 1000,
        minTickInterval: 60 * 1000,
            //minRange:60*1000
            // dateTimeLabelFormats: {
            //     millisecond: '%H:%M:%S.%L',
            //     second: '%H:%M:%S',
            //     minute: '%H:%M',
            //     hour: '%H:%M',
            //     day: '%m-%d',
            //     week: '%m-%d',
            //     month: '%Y-%m',
            //     year: '%Y'
            // }
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

export default {
    'temp': _.merge({}, defaultOption, {
        title: {
            text: '温度'
        },
        yAxis: {
            title: {
                text: '摄制度'
            }
        }
    }),
    'speed': _.merge({}, defaultOption, {
        title: {
            text: '速度'
        },
        yAxis: {
            title: {
                text: 'm/s'
            }
        }
    }),
    'voltage': _.merge({}, defaultOption, {
        title: {
            text: '电压'
        },
        yAxis: {
            title: {
                text: 'V'
            }
        }
    }),
    'temperature': _.merge({}, defaultOption, {
        title: {
            text: '温度'
        },
        yAxis: {
            title: {
                text: '摄制度'
            }
        }
    }),
    'humility': _.merge({}, defaultOption, {
        title: {
            text: '湿度'
        },
        yAxis: {
            title: {
                text: '%'
            }
        }
    }),
    'solar-radiation': _.merge({}, defaultOption, {
        title: {
            text: '光照'
        },
        yAxis: {
            title: {
                text: 'lux'
            }
        }
    }),
    'wind-velocity': _.merge({}, defaultOption, {
        title: {
            text: '风速'
        },
        yAxis: {
            title: {
                text: 'm/s'
            }
        }
    }),
    'wind-speed': _.merge({}, defaultOption, {
        title: {
            text: '风速'
        },
        yAxis: {
            title: {
                text: 'm/s'
            }
        }
    }),
    'wind-direction': _.merge({}, defaultOption, {
        title: {
            text: '风向'
        },
        yAxis: {
            title: {
                text: '°'
            }
        }
    }),
    'solar radiation': _.merge({}, defaultOption, {
        title: {
            text: '光照'
        },
        yAxis: {
            title: {
                text: 'lux'
            }
        }
    }),
    'wind velocity': _.merge({}, defaultOption, {
        title: {
            text: '风速'
        },
        yAxis: {
            title: {
                text: 'm/s'
            }
        }
    }),
    'wind direction': _.merge({}, defaultOption, {
        title: {
            text: '风向'
        },
        yAxis: {
            title: {
                text: '°'
            }
        }
    }),
    'rainfall': _.merge({}, defaultOption, {
        chart: {
            type: 'column'
        },
        title: {
            text: '降雨量'
        },
        yAxis: {
            title: {
                text: 'mm'
            }
        }
    }),
}