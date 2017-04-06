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
        <h3 class="panel-title" style="color: #fff;text-align:right;">详细>></h3>
      </router-link>
    </div>
    <div class="panel-body">
      <highcharts :options="chart" ref="highcharts"></highcharts>
    </div>
  </div>
  <div v-if="selectedDevice!==null" class="panel panel-default panel-primary"  >
    <div class="panel-heading" >
      <router-link :to="dataUrl + 'image'">
        <h3 class="panel-title" style="color: #fff;text-align:right;">详细>></h3>
      </router-link>
    </div>
    <gallery :images="images"></gallery>
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
        gallerise: [],
        charts: {},
        images: {},
      }
    },
    computed: {
      dataUrl: function () {
        return this.station ? '/station/' + this.station.id + '/detail?device_id='+ this.devices[this.selectedDevice].id +'&type=' : '';
      },

    },
    watch: {
      selectedDevice: function () {
        this.loadDeviceData(this.devices[this.selectedDevice])
      }
    },
    methods: {
      loadDeviceData (device) {
        var query = {
          start_at: moment().subtract(7,'day').format('YYYY-MM-DD'),
          end_at: moment().add(1,'day').format('YYYY-MM-DD'),
          limit: 10000,
        };
        var self = this;
        var station = this.$route.params.station;
        api.getDeviceData(device , query, function (err, data) {
          self.charts = api.data2charts(data);
          self.images = _.filter(data, {type:'image'});
        });
      },
    },
    created:function () {
      this.$http.get('/api/station/'+ this.$route.params.station+'?with=devices.configs').then(function (res) {
        var station = res.body
        station.devices = _.map(station.devices, function (v) {
          v.config = _.last(v.configs);
          return v;
        })
        this.devices = station.devices;
        this.station = station;
        this.selectedDevice = 0;
      });
    }
  };

</script>
