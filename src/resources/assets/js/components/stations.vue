<template>
<div>
    <div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
      <div id="header" style="width: 90%;margin: auto;">
        <div id="title">
          <h3>Station 列表</h3>
          <!-- <h3>xxxxxx</h3> -->
        </div>
      </div>
    </div>
    <div class="" style="width: 90%;margin: auto;">
      <table class="table table-bordered table-striped table-hover">
        <tr class="fatal">
          <th>名称</th>
          <th>类型</th>
          <th>地址</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
        <template v-for="station in stations">
          <tr class="">
            <!-- <td>{{ station.id }}</td> -->
            <td>{{ station.name }}</td>
            <td>{{ station.type }}</td>
            <td>{{ station.location }}</td>
            <td><img height="20" src="http://et.cern.ac.cn/static/images/3.png" class="signal"></td>
            <td>
              <router-link :to="'/station/'+station.id"><img height="20" src="http://et.cern.ac.cn/static/images/info.png" class="signal"></router-link>              
              <router-link :to="'/station/'+station.id+'/dashboard'"><img height="20" src="http://et.cern.ac.cn/static/images/dashboard.png" class="signal"></router-link>
            </td>
          </tr>
        </template>
      </table>
    </div>
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