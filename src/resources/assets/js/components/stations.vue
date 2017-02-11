<template>
<div class="">
    <table class="table table-bordered table-striped table-hover">
      <tbody>
        <tr class="fatal">
          <th>名称</th>
          <th>类型</th>
          <th>地址</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
        <tr v-for="station in stations" class="">
          <td>{{ station.name }}</td>
          <td>{{ station.type }}</td>
          <td>{{ station.location }}</td>
          <td><img height="20" src="http://et.cern.ac.cn/static/images/3.png" class="signal"></td>
          <td>
            <router-link :to="'/station/'+station.id"><img height="20" src="http://et.cern.ac.cn/static/images/info.png" class="signal"></router-link>              
            <router-link :to="'/station/'+station.id+'/dashboard'"><img height="20" src="http://et.cern.ac.cn/static/images/dashboard.png" class="signal"></router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    data: function () {
      return {
        stations: []
      }
    },
    mounted: function () {
      var self = this;
      $.get('/api/station', function (stations) {
        self.stations = stations.items;
      })
    }
  }
</script>