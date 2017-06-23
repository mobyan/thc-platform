<template>
<div class="">
    <!--search part-->
    <div>
      <div v-if="apps.length > 1" style="float: right;">
        <label>产品线：</label><select v-model="currentApp" style="z-index: 9999; position: relative;"><option v-for="(app, index) in apps" :value="app.id">{{app.id}} - {{app.name}}</option></select>&nbsp;&nbsp;&nbsp;
        <button @click="search">搜索</button>
      </div>
    </div>
    <table class="table table-bordered table-striped table-hover">
      <tbody>
        <tr class="fatal">
          <th>名称</th>
          <th>产品线</th>
          <th>类型</th>
          <th>地址</th>
          <th>区划</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
        <tr v-for="(station, index) in stations" class="">
          <td>{{ station.name }}</td>
          <td>{{ station.app.name}}</td>
          <td>{{ station.type }}</td>
          <td>{{ station.location }}</td>
          <td>{{ station.code.merged_name}}</td>
          <td><img height="20" :src="'/image/'+ station.status+'.png'" class="signal"></td>
          <td>
            <router-link :to="'/admin/station/'+station.id"><img height="20" src="/image/info.png" class="signal"></router-link>
            <span @click="remove(index)"><img width="16px" height="16px" src="/image/remove.png"></span>
          </td>
        </tr>
             <tr v-if="editable"><td style="text-align: right;" colspan="7">
         <button class="btn btn-primary" @click.prevent="go">添加</button>
     </td></tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import bootbox from 'bootbox'
  export default {
    data: function () {
      return {
        editable: thc.can('sys_w', 0),
        stations: [],
        apps: [],
        currentApp: null,
      }
    },
    created: function () {
      var self = this;
      this.$http.get('/api/app').then(function(res){
        self.apps = res.body.items;
        self.currentApp = self.apps[0].id;
      }).then(function(){
        this.$http.get('/api/station?with=app,code&app_id='+self.currentApp).then(function (res) {
          self.stations = res.body.items;
        });
      });

    },
    methods: {
        go: function () {
            this.$router.push({name:'admin-station', params:{station:0}, query: {op:'create'}})
        },
        remove: function (index) {
            var self = this;
            bootbox.confirm('确认删除？', function (result) {
                if (result) {
                    self.$http.delete('/api/station/'+self.stations[index].id).then(function () {
                        self.stations.splice(index, 1);
                    })
                }
          })
        },
        search: function(){
            var self = this;
            this.$http.get('/api/station?with=app,code&app_id='+this.currentApp).then(function(res){
              self.stations = res.body.items;
            })
        }
    }
  }
</script>
