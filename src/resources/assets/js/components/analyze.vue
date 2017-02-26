<template>
  <div class="card">
    <!-- for Vue 2.0 -->
    <div class="row" style="margin-bottom: 10px;">
      <span><!-- Departure --> Date：</span>
      <date-picker id="start_at" :date="start_at" :option="dp.option" :limit="limit"></date-picker> - 
      <date-picker id="end_at" :date="end_at" :option="dp.option" :limit="limit"></date-picker>
      <button type="button" class="btn btn-primary btn-md" @click="loadDeviceData()">
        <!-- <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Star -->
        确定
      </button>
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
        images: {t_11:{}},
      }
    },
    components: {
      'date-picker': myDatepicker
    },
    created () {
      this.loadDeviceData();
    },
    methods: {
      loadDeviceData () {
        var query = {
          start_at: this.start_at.time,
          end_at: this.end_at.time,
        };
        var self = this;
        var type = this.$route.query.type;
        api.getDeviceData(this.$route.path, query, function (err, data) {
          if (type == 'image') {
            // self.images = _.filter(data, {type});
            self.images = {
              't_12': {
                name: 't_12',
                type: 'image',
                data: [
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:11'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:11'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:12'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:12'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:12'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:13'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:13'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:13'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:14'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:14'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:14'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:15'},
                {value: '/image/1.jpg', ts:'2017-02-01 11:11:15'},
                ]
              }
            }
            console.log(self.images)
          } else {
            console.log(data)
            self.charts = api.data2charts(_.filter(data, {type: type}));
          }
        })
      },
    }
  }
</script>
