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
    <div v-for="gallery in gallerise" class="panel-body">
      <div class="row">
        <div v-for="image in page(gallery.data, pn, ps)" class="col-xs-6 col-md-3">
          <div class="thumbnail">
            <img :src="'http://thc-platfrom-storage.b0.upaiyun.com' + image.value" alt="alt">
          </div>
        </div>
      </div>
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li>
            <a href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li v-for="i in 10"><a href="#">{{i}}</a></li>
          <li>
            <a href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
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
        gallerise: [],
        charts: {},
        pn: 1,
        ps: 10,
      }
    },
    computed: {
      dataUrl: function () {
        return this.station ? '/station/' + this.station.id + '/device/' + this.devices[this.selectedDevice].id + '/data?type=' : '';
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
          start_at: moment().subtract(700,'day').format('YYYY-MM-DD'),
          end_at: moment().format('YYYY-MM-DD'),
          limit: 10000,
        };
        var self = this;
        var station = this.$route.params.station;
        api.getDeviceData('/station/'+station+'/device/'+device.id+'/data' , query, function (err, data) {
          self.charts = api.data2charts(data);
          self.gallerise = _.filter(data, {type:'image'});
        });
      },
      page(items, pn, ps) {
        alert('fff')
        var res = _.slice(items, ps*(pn-1), ps);
        console.log(res)
        return res;
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
        self.selectedDevice = 0;
      });
    }
  };

</script>