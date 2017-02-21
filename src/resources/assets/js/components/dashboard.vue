<template>
  <div class="">
    <label>设备：</label><select class="form-control" v-model="selectedDevice">
    <option v-for="(device,k) in devices" :value="k" >{{ device.name }}</option>
  </select>
  <highcharts v-for="chart in charts" :options="chart" ref="highcharts"></highcharts>
  <div>
    <div>
      <h3>基站图片</h3>
    </div>
    <div class="row">
      <div v-for="url in gallery" class="col-xs-6 col-md-3">
        <div class="thumbnail">
          <img src="/image/1.jpg" alt="alt">
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import api from '../api'
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
        if (type == 'image') return;
        charts[type] = charts[type] || _.cloneDeep(defaultOptions[type]);
        charts[type].series.push(v);
      })
        return charts;
      },
      gallery: function () {
        var image = _.find(this.datas, {_type:'image'}) || {};
        return image.data;
      }
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
          app.datas = api.formatData(data.items, device.config);
        });
      }
    },
    created:function () {
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

</script>