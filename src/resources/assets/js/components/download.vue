<template>
  <div class="card">
    <div style="margin-bottom: 10px;">
      <form class="form">
        <div class="form-group">
          <label style="width: 100%;">站点-设备：</label>
          <select v-model="selected_device_ids" multiple="true" style="width: 100%;" class="form-control">
            <option v-for="device in devices" :value="device.id">
              {{ device.name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label style="width: 100%;">时间：</label>
          <date-picker id="start_at" :date="start_at" :option="dp.option" :limit="limit"></date-picker> to
          <date-picker id="end_at" :date="end_at" :option="dp.option" :limit="limit"></date-picker>
        </div>
        <button type="button" class="btn btn-default" v-for="shortcut in shortcuts" @click="linkWithDatepicker(shortcut.offset)" style="margin-right: 5px;" >{{shortcut.name}}</button>
        <div class ="form-group">
          <label>下载内容：</label>
          <!-- <label class="btn btn-primary"> -->
          <label>
            <input type="checkbox" v-model="with_image" autocomplete="off"> 图片
          </label>
          <!-- <label class="btn btn-primary"> -->
          <label>
            <input type="checkbox" v-model="with_data" autocomplete="off"> 数据
          </label>
        </div>
        <button type="button" class="btn btn-primary" @click.prevent="downloadDeviceData">下载</button>
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
          <tr v-for="job, index in download_jobs" class="">
            <td>{{ index + 1 }}</td>
            <td>{{ job.created_at }}</td>
            <td>{{ job.updated_at }}</td>
            <td>{{ job.status}}</td>
            <template v-if="job.status=='completed'">
              <td>
                <span style="float: left;" @click="download_job(job.url)"><img height="16px" width="16px" src="/image/dl.png"></span>
                <span style="float: right;" @click.prevent="delete_job(job.id)" ><img height="16px" width="16px" src="/image/remove.png"></span>
              </td>
            </template>
            <template v-else>
              <td>
              </td>
            </template>
          </tr>
        </tbody>
      </table>
      <button type="button" class="btn btn-primary" @click.prevent="get_belonged_jobs" style="float: right">刷新</button>
    </div>
  </div>
</template>

<script>
  import myDatepicker from 'vue-datepicker'
  import configs from '../configs'
  import bootbox from 'bootbox'
  export default {
    data: function(){
      return {
        dp: configs.datepicker,
        start_at: {time:moment().subtract(1,'day').format('YYYY-MM-DD')},
        end_at: {time:moment().format('YYYY-MM-DD')},
        limit: [{
          type: 'fromto',
          from: '2016-01-01',
          // to: '2017-01-01',
          to: moment().add(1,'day').format('YYYY-MM-DD'),
        }],
        with_data: true,
        with_image: true,
        shortcuts: [
        {name: '1天',offset: 1,},
        {name: '3天',offset: 3,},
        {name: '7天',offset: 7,},
        {name: '15天',offset: 15,},
        {name: '30天',offset: 30,},
        ],
        download_jobs: [],
        stations: [],
        devices: [],
        selected_device_ids: [],
      }
    },
    components: {
      'date-picker': myDatepicker
    },
    methods: {
      downloadDeviceData: function(){
        if(this.selected_device_ids.length == 0){
          alert('请至少选择一个设备');
          return;
        }
        if(!(this.with_data||this.with_image)){
          alert('请至少选择图片或数据');
          return;
        }
        var query = {};
        query.device_ids = this.selected_device_ids;
        query.with_data = this.with_data;
        query.with_image = this.with_image;
        query.start_at = this.start_at.time;
        query.end_at = this.end_at.time;
        var self = this;
        this.$http.post('/api/download', query).then(function(res){
          // console.log(res.data);
          // console.log(window.thc.user);
          self.get_belonged_jobs();
        });
      },
      linkWithDatepicker: function(offset){
        var query = {};
        query.start_at = moment().subtract(offset,'day').format('YYYY-MM-DD');
        query.end_at = moment().add(1,'day').format('YYYY-MM-DD');
        this.start_at = {time: query.start_at};
        this.end_at = {time: moment().format('YYYY-MM-DD')};
      },
      get_belonged_jobs: function(){
        var self = this;
        this.$http.get('/api/download').then(function(res){
          self.download_jobs = res.body.items;
        })
      },
      delete_job: function(id){
        var self = this;
        bootbox.confirm('确认删除？', function(result){
          if(result){
            self.$http.delete('/api/download/' + id).then(function(){
              self.get_belonged_jobs();
            });
          }
        });
      },
      download_job: function(relative_url){
        // alert('Download !');
        if (!relative_url) {
          alert('no valid url !');
          return;
        }
        var url = 'http://thc-platfrom-storage.b0.upaiyun.com' + relative_url;
        console.log(url);
        var a = $("<a>")
          .attr("href", url)
          .appendTo("body");
        a[0].click();
        a.remove();
      },
      get_belonged_devices: function(){
        var self = this;
        this.$http.get('/api/station').then(function(res){
          self.stations = res.body.items;
          for (var i = self.stations.length - 1; i >= 0; i--) {
            let station_name = self.stations[i].name;
            self.$http.get('/api/station/' + self.stations[i].id + '/device').then(function (res) {
              for(var j = 0, length1 = res.body.items.length; j < length1; j++){
                res.body.items[j].name = station_name + '-' + res.body.items[j].name;
              }
              self.devices = self.devices.concat(res.body.items);
              let tmp_devices = _.sortBy(self.devices, function(item){
                return item.id;
              })
              self.devices = tmp_devices
            })
          }
        })
      },
      refresh: function(){
        this.$router.go();
      }
    },
    created: function()
    {
      // this.get_belonged_jobs();
      // this.get_belonged_devices();
      $.when(this.get_belonged_jobs(), this.get_belonged_devices()).then();
    },
  }
</script>