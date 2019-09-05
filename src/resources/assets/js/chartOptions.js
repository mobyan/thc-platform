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
        text: ''
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
        title_v: {
            text: '摄氏度'
        },
        title: {
            text: ''
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
    plotOptions: {
        spline: {
            lineWidth: 1,
            fillOpacity: 0.1,
            marker: {
                enabled: true,
                states: {
                    hover: {
                        enabled: true,
                        radius: 1.5
                    }
                }
            },
            shadow: false
        }
    },
    series: [], //format [{name: "name", data: [[x1,y1],[x2,y2]]},{name: "name", data:[[x1,y1],[x2,y2]]}]
};

export default {
    'temp': _.merge({}, defaultOption, {
        // title: {
        //     text: '温度'
        // },
        yAxis: {
            title_v: {
                text: '摄氏度'
            },
            title: {
                text: ''
            },
        }
    }),
    'speed': _.merge({}, defaultOption, {
        // title: {
        //     text: '速度'
        // },
        yAxis: {
            title_v: {
                text: 'm/s'
            },
            title: {
                text: ''
            },
        }
    }),
    'voltage': _.merge({}, defaultOption, {
        // title: {
        //     text: '电压'
        // },
        yAxis: {
            title_v: {
                text: 'V'
            },
            title: {
                text: ''
            },
        }
    }),
    'temperature': _.merge({}, defaultOption, {
        // title: {
        //     text: '温度'
        // },
        yAxis: {
            title_v: {
                text: '摄氏度'
            },
            title: {
                text: ''
            },
        }
    }),
    'soilhumility': _.merge({}, defaultOption, {
        // title: {
        //     text: '湿度'
        // },
        yAxis: {
            title_v: {
                text: '%'
            },
            title: {
                text: ''
            },
        }
    }),
    'solar-radiation': _.merge({}, defaultOption, {
        // title: {
        //     text: '光照'
        // },
        yAxis: {
            title_v: {
                text: 'lux'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind-velocity': _.merge({}, defaultOption, {
        // title: {
        //     text: '风速'
        // },
        yAxis: {
            title_v: {
                text: 'm/s'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind-speed': _.merge({}, defaultOption, {
        // title: {
        //     text: '风速'
        // },
        yAxis: {
            title_v: {
                text: 'm/s'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind-direction': _.merge({}, defaultOption, {
        // title: {
        //     text: '风向'
        // },
        yAxis: {
            title_v: {
                text: '°'
            },
            title: {
                text: ''
            },
        }
    }),
    'solar radiation': _.merge({}, defaultOption, {
        // title: {
        //     text: '光照'
        // },
        yAxis: {
            title_v: {
                text: 'lux'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind velocity': _.merge({}, defaultOption, {
        // title: {
        //     text: '风速'
        // },
        yAxis: {
            title_v: {
                text: 'm/s'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind direction': _.merge({}, defaultOption, {
        // title: {
        //     text: '风向'
        // },
        yAxis: {
            title_v: {
                text: '°'
            },
            title: {
                text: ''
            },
        }
    }),
    'rainfall': _.merge({}, defaultOption, {
        chart: {
            type: 'column'
        },
        // title: {
        //     text: '降雨量'
        // },
        yAxis: {
            title_v: {
                text: 'mm'
            },
            title: {
                text: ''
            },
        }
    }),
    'pressure': _.merge({}, defaultOption, {
	chart: {
	    type: 'column'
	},
	yAxis: {
	    title_v: {
                text: 'pa'
            },
            title: {
                text: ''
            },
        }
    }),
    'humility': _.merge({}, defaultOption, {
        // title: {
        //     text: '湿度'
        // },
        yAxis: {
            title_v: {
                text: '%'
            },
            title: {
                text: ''
            },
        }
    }),
    'solar-radiation': _.merge({}, defaultOption, {
        // title: {
        //     text: '光照'
        // },
        yAxis: {
            title_v: {
                text: 'lux'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind-velocity': _.merge({}, defaultOption, {
        // title: {
        //     text: '风速'
        // },
        yAxis: {
            title_v: {
                text: 'm/s'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind-speed': _.merge({}, defaultOption, {
        // title: {
        //     text: '风速'
        // },
        yAxis: {
            title_v: {
                text: 'm/s'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind-direction': _.merge({}, defaultOption, {
        // title: {
        //     text: '风向'
        // },
        yAxis: {
            title_v: {
                text: '°'
            },
            title: {
                text: ''
            },
        }
    }),
    'solar radiation': _.merge({}, defaultOption, {
        // title: {
        //     text: '光照'
        // },
        yAxis: {
            title_v: {
                text: 'lux'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind velocity': _.merge({}, defaultOption, {
        // title: {
        //     text: '风速'
        // },
        yAxis: {
            title_v: {
                text: 'm/s'
            },
            title: {
                text: ''
            },
        }
    }),
    'wind direction': _.merge({}, defaultOption, {
        // title: {
        //     text: '风向'
        // },
        yAxis: {
            title_v: {
                text: '°'
            },
            title: {
                text: ''
            },
        }
    }),
    'rainfall': _.merge({}, defaultOption, {
        chart: {
            type: 'column'
        },
        // title: {
        //     text: '降雨量'
        // },
        yAxis: {
            title_v: {
                text: 'mm'
            },
            title: {
                text: ''
            },
        }
    }),
    'pressure': _.merge({}, defaultOption, {
	chart: {
	    type: 'column'
	},
	yAxis: {
	    title_v: {
                text: 'pa'
            },
            title: {
                text: ''
            },
        }
    }),
    'CO': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'mg/m3'
            },
            title: {
                text: ''
            },
        }
    }),
    'O3': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'ug/m3'
            },
            title: {
                text: ''
            },
        }
    }),
    'SO2': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'ug/m3'
            },
            title: {
                text: ''
            },
        }
    }),
    'NO2': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'ug/m3'
            },
            title: {
                text: ''
            },
        }
    }),
    'PM2_5': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'ug/m3'
            },
            title: {
                text: ''
            },
        }
    }),
    'PM10': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'ug/m3'
            },
            title: {
                text: ''
            },
        }
    }),
    'diams': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'mm'
            },
            title: {
                text: ''
            },
        }
    }),
    'par': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'umol/m2.s'
            },
            title: {
                text: ''
            },
	}}),
    'cond': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'ms/cm'
            },
            title: {
                text: ''
            },
	}}),
    'ph': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'PH'
            },
            title: {
                text: ''
            },
	}}),
    'volt': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'v'
            },
            title: {
                text: ''
            },
	}}),
    'do': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'DO'
            },
            title: {
                text: ''
            },
	}}),
    'turb': _.merge({}, defaultOption, {
	chart: {
	    type: 'spline'
	},
	yAxis: {
	    title_v: {
                text: 'NTU'
            },
            title: {
                text: ''
            },
	}})
}
