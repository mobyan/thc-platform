<template>
  <div class="card">
    <!-- for Vue 2.0 -->
    <div style="margin-bottom: 10px;">
      <form class="form">

        <div class="form-group">
          <label style="width: 100%;">时间：</label>
          <date-picker id="start_at" :date="start_at" :option="dp.option" :limit="limit"></date-picker> to
          <date-picker id="end_at" :date="end_at" :option="dp.option" :limit="limit"></date-picker>
        </div>
        <div class ="form-group">
          <label>下载内容：</label>
          <label class="btn btn-primary">
            <input type="checkbox" v-model="withImage" checked autocomplete="off"> 图片
          </label>
          <label class="btn btn-primary">
            <input type="checkbox" v-model="withData" checked autocomplete="off"> 数据
          </label>
        </div>
        <button type="button" class="btn btn-primary" @click="downloadDeviceData(withImage, withData)">下载</button>

      </form>
    </div>
    <div class="">
        <table class="table table-bordered table-striped table-hover">
          <tbody>
            <tr class="fatal">
              <th>序号</th>
              <th>创建时间</th>
              <th>更新时间</th>
              <th>状态</th>
              <th>操作</th>
            </tr>
            <tr v-for="job in jobs" class="">
              <td>{{ job.id }}</td>
              <td>{{ job.created_at }}</td>
              <td>{{ job.updated_at }}</td>
              <td>{{ job.status}}</td>
              <td>
                <span style="float: right;" @click="download(job)" ><img height="16px" width="16px" src="/image/dl.png"></span>
                <span style="float: right;" @click="delete(job)" ><img height="16px" width="16px" src="/image/remove.png"></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
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
        types: [],
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
      var type = this.$route.query.type;
      this.selectedType = type;
      this.loadDeviceData(type);
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
        api.getDeviceData(this.$route.path, query, function (err, data) {
          self.types = _.reduce(data, (res, v)=> {
            res[v.type] = _.find(sensors, {type:v.type}) || {};
            return res;
          }, {});
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
