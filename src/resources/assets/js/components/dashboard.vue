<template>
  <div class="">
      <label>设备：</label><select class="form-control" v-model="selectedDevice">
        <option v-for="(device,k) in devices" :value="k" >{{ device.name }}</option>
    </select>
    <highcharts v-for="chart in charts" :options="chart" ref="highcharts"></highcharts>
  </div>
</template>

<script>
var defaultOptions = require('../chartOptions');

export default  {
  name: 'my-dashboard',
  data : function () {
    return {
      devices: [],
      station: null,
      selectedDevice: 0,
      datas: [],
    }
  },
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
  },
  mounted:function () {
    var self = this;
    $.get('/api/station/'+ this.$route.params.station+'?with=devices.configs', function (station) {
      station.devices = _.map(station.devices, function (v) {
        v.config = _.last(v.configs);
        return v;
      })
      self.devices = station.devices;
      self.station = station;
    });
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

</script>