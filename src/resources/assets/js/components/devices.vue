<template>
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
        <tr v-for="device in devices">
         <td>{{device.name}}</td>
         <td>{{device.type}}</td>
         <td>{{device.company}}</td>
         <td>{{device.model}}</td>
         <td>{{device.sn}}</td>
         <td>{{device.version}}</td>
         <td><router-link :to="'/station/'+ station + '/device/' + device.id"><img height="20" src="https://et.cern.ac.cn/static/images/info.png" class="signal"></router-link></td>
     </tr>
 </tbody>
</table>
</div>
</template>
<script >
    export default {
        props: ['station'],
        data: function () {
            return {
                devices: [],
            }
        },
        mounted: function () {
            var self = this;
            $.get('/api/station/' + this.station + '/device', function (devices) {
                self.devices = devices.items;
            })
        }
    }
</script>