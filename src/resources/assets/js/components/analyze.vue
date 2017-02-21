<template>
  <div class="card">
    <!-- for Vue 2.0 -->
    <div class="row">
      <span>Departure Date：</span>
      <date-picker :date="dp.startTime" :option="dp.option" :limit="dp.limit"></date-picker>
  </div>
  <highcharts v-for="chart in charts" :options="chart" ref="highcharts"></highcharts>
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
            charts: {},
        }
    },
    components: {
        'date-picker': myDatepicker
    },
    created () {
        var self = this;
        api.getDeviceData(this.$route.path, function (err, data) {
            self.charts = api.data2charts(data);
            console.log(self.charts)
        })
    }
}
</script>
