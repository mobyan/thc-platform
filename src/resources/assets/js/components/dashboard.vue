<template>
  <div class="">
    <div style="margin-bottom:10px;">
      <label>设备：</label><select class="form-control" v-model="selectedDevice">
      <option v-for="(device,k) in devices" :value="k" >{{ device.name }}</option>
    </select>
  </div>
  <div class="panel panel-default panel-primary" v-for="(chart,type) in charts" >
    <div class="panel-heading" >
      <router-link :to="dataUrl + type">
        <h3 class="panel-title">&nbsp;</h3>
      </router-link>
    </div>
    <div class="panel-body">
      <highcharts :options="chart" ref="highcharts"></highcharts>
    </div>
  </div>
  <div v-if="selectedDevice!==null" class="panel panel-default panel-primary"  >
    <div class="panel-heading" >
      <router-link :to="dataUrl + 'image'">
        <h3 class="panel-title">&nbsp;</h3>
      </router-link>
    </div>
    <div class="panel-body">
      <div class="row">
        <div v-for="url in gallery" class="col-xs-6 col-md-3">
          <div class="thumbnail">
            <img src="/image/1.jpg" alt="alt">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import api from '../api'
  import defaultOptions from '../chartOptions';

  export default  {
    name: 'my-dashboard',
    data : function () {
      return {
        devices: [],
        station: null,
        selectedDevice: null,
        datas: [],
        charts: {},
      }
    },
    computed: {
      chartsx: function() {
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
      dataUrl: function () {
        return this.station ? '/station/' + this.station.id + '/device/' + this.devices[this.selectedDevice].id + '/data?type=' : '';
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
      loadDeviceData (device) {
        var query = {
          limit: 1000,
        };
        var self = this;
        var station = this.$route.params.station;
        api.getDeviceData('/station/'+station+'/device/'+device.id+'/data' , query, function (err, data) {
          self.charts = api.data2charts(data);
        });
      },
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
        self.selectedDevice = 0;
      });
    }
  };

</script>