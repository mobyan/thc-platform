<template>
  <div class="card">
    <!-- for Vue 2.0 -->
    <div style="margin-bottom: 10px;">
    <form class="form-inline">
      <label>类型</label>

    <select class="form-control" v-model="selectedType">
      <option v-for="(v,t) in types" :value="t">{{t}}</option>
    </select>
      <label>Date</label>
      <date-picker id="start_at" :date="start_at" :option="dp.option" :limit="limit"></date-picker> - 
      <date-picker id="end_at" :date="end_at" :option="dp.option" :limit="limit"></date-picker>
      <button type="button" class="btn btn-primary btn-md" @click="loadDeviceData(selectedType)">
        <!-- <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Star -->
        确定
      </button>
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
  export default {
    data () {
      return {
        dp: configs.datepicker,
        start_at: {time:moment().subtract(100,'day').format('YYYY-MM-DD')},
        end_at: {time:moment().format('YYYY-MM-DD')},
        charts: {},
        limit: [{
          type: 'fromto',
          from: '2016-01-01',
          // to: '2017-01-01',
          to: moment().add(1,'day').format('YYYY-MM-DD'),
        }],
        images: {},
        types: [],
        selectedType: null,
      }
    },
    components: {
      'date-picker': myDatepicker
    },
    created () {
      var type = this.$route.query.type;
      this.selectedType = type;
      this.loadDeviceData(type);
    },
    methods: {
      loadDeviceData (type) {
        this.images = {};
        this.charts = {};
        var query = {
          start_at: this.start_at.time,
          end_at: this.end_at.time,
        };
        var self = this;
        api.getDeviceData(this.$route.path, query, function (err, data) {
          self.types = _.reduce(data, (res, v)=> {
            res[v.type] = true;
            return res;
          }, {});
          // console.log(data)
          if (type == 'image') {
            self.images = _.filter(data, {type});
          } else {
            self.charts = api.data2charts(_.filter(data, {type: type}));
          }
        })
      },
    }
  }
</script>
