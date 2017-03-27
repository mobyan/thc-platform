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
            <th>状态</th>
            <th>操作</th>
        </tr>
        <tr v-for="device in devices">
         <td>{{device.name}}</td>
         <td>{{device.type}}</td>
         <td>{{device.company}}</td>
         <td>{{device.model}}</td>
         <td>{{device.sn}}</td>
         <td>{{device.version}}</td>
        <td><img height="20" :src="'/image/'+ device.status+'.png'" class="signal"></td>
         <td><router-link :to="'/station/'+ station + '/device/' + device.id"><img height="20" src="/image/info.png" class="signal"></router-link></td>
     </tr>
     <tr v-if="editable"><td style="text-align: right;" colspan="8">
         <button class="btn btn-primary" @click="go">添加</button>
     </td></tr>
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
                editable: thc.can('app_w'),
                station_id: this.$route.params.station,
            }
        },
        created: function () {
            var self = this;
            this.$http.get('/api/station/' + this.station + '/device').then(function (res) {
                this.devices = res.body.items;
            })
        },
        methods: {
            go: function () {
                this.$router.push({name:'device', params:{station:this.station_id, device:0}, query: {op:'create'}})
            }
        }
    }
</script>