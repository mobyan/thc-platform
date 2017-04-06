<template>
  <div class="card">
    <!-- for Vue 2.0 -->
    <div style="margin-bottom: 10px;">
      <form class="form">
          <div class="form-group">

          <label>设备：</label>
          <template v-for="device in devices">
            <input type="checkbox" :id="device.id" :value="device" v-model="selectedDevices">
            <label :for="device.id">{{device.name}}</label>
          </template>
          </div>          
          <div class="form-group">

          <label>类型：</label>
          <select class="form-control" v-model="selectedType">
            <option v-for="(v,t) in types" :value="t">{{v.type_desc}}</option>
          </select>
          </div>
        <div class="form-group">
          <label style="width: 100%;">时间：</label>
          <date-picker id="start_at" :date="start_at" :option="dp.option" :limit="limit"></date-picker> to  
          <date-picker id="end_at" :date="end_at" :option="dp.option" :limit="limit"></date-picker>
        </div>
        <button type="button" class="btn btn-primary" @click="loadDeviceData(selectedType)">确定</button>
        <button type="button" class="btn btn-default" v-for="shortcut in shortcuts" @click="loadDeviceData(selectedType, shortcut.offset)" style="margin-right: 5px;" >{{shortcut.name}}</button>
      </form>
    </div>
    <highcharts v-for="chart in charts" :options="chart" ref="highcharts"></highcharts>
    <gallery :images="images"></gallery>
  </div>
</template>

<script>
  import myDatepicker from 'vue-datepicker'
  import api from '../api'
  import configs from '../configs'
  import sensors from '../configs/sensors'
  export default {
    data () {
      return {
        station_id: this.$route.params.station,
        devices: [],
        selectedDevices: [],
        dp: configs.datepicker,
        start_at: {time:moment().subtract(1,'day').format('YYYY-MM-DD')},
        end_at: {time:moment().format('YYYY-MM-DD')},
        charts: {},
        limit: [{
          type: 'fromto',
          from: '2016-01-01',
          // to: '2017-01-01',
          to: moment().add(1,'day').format('YYYY-MM-DD'),
        }],
        images: {},
        types: _.reduce(sensors, function (carry, v) { carry[v.type]=v;return carry;}, {}),
        selectedType: null,
        shortcuts: [
        {name: '1天',offset: 1,},
        {name: '3天',offset: 3,},
        {name: '7天',offset: 7,},
        {name: '15天',offset: 15,},
        {name: '30天',offset: 30,},
        ],
      }
    },
    components: {
      'date-picker': myDatepicker
    },
    created () {
      this.$http.get('/api/station/'+this.station_id+'/device').then(function (res) {
        // var d1 = res.body.items[0];
        // var d2 = _.cloneDeep(d1);
        // d2.name += '复制';
        // this.devices = [d1,d2];
        this.devices = res.body.items;
        this.selectedDevices = _.filter(this.devices, {id: parseInt(this.$route.query.device_id)}) || [this.devices[0]];
        this.loadDeviceData(type);

      })
      var type = this.$route.query.type;
      this.selectedType = type;
    },
    methods: {
      loadDeviceData (type, offset) {
        this.images = {};
        this.charts = {};
        var query = {};
        if (offset) {
          query.start_at = moment().subtract(offset,'day').format('YYYY-MM-DD');
          query.end_at = moment().add(1,'day').format('YYYY-MM-DD');
          this.start_at = {time: query.start_at};
          this.end_at = {time: moment().format('YYYY-MM-DD')};
        } else {
          query.start_at = this.start_at.time;
          query.end_at = moment(this.end_at.time).add(1,'day').format('YYYY-MM-DD');
        }
        var self = this;
        api.getDeviceData(this.selectedDevices, query, function (err, data) {
          if (type == 'image') {
            self.images = _.filter(data, {type});
            console.log(self.images)
          } else {

            self.charts = api.data2charts(_.filter(data, {type: type}));
          }
        })
      },
    }
  }
</script>
