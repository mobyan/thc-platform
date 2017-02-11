<template>
  <div>
    <div class="">
      <p><label>id</label>: {{station.id}}</p>
      <p><label>name</label>: {{station.name}}</p>
      <p><label>type</label>: {{station.type}}</p>
      <p><label>location</label>: {{station.location}}</p>
      <p><label>lat</label>: {{station.lat}}</p>
      <p><label>lon</label>: {{station.lon}}</p>
      <p><label>alt</label>: {{station.alt}}</p>
      <p><label>status</label>: {{station.status}}</p>
    </div>
    <div class="">
      <table class="table table-bordered table-striped table-hover">
        <tbody>
          <tr>
            <th>名称</th>
            <th>类型</th>
            <th>公司</th>
            <th>型号</th>
            <th>序列号</th>
            <th>版本</th>
            <th>操作</th>
          </tr>
          <tr v-for="device in station.devices">
           <td>{{device.name}}</td>
           <td>{{device.type}}</td>
           <td>{{device.company}}</td>
           <td>{{device.model}}</td>
           <td>{{device.sn}}</td>
           <td>{{device.version}}</td>
           <td><router-link :to="'/station/'+ station.id + '/device/' + device.id"><img height="20" src="https://et.cern.ac.cn/static/images/info.png" class="signal"></router-link></td>
         </tr>
       </tbody>
     </table>
   </div>
 </div>
</template>

<script>
  export default {
    data: function () {
      return {
        station: {}
      }
    },
    mounted: function () {
      var self = this;
      $.get('/api/station/'+this.$route.params.station + '?with=devices', function (station) {
        self.station = station;
      })
    }
  }
</script>