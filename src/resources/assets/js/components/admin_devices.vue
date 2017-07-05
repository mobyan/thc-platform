<template>
    <div class="">
      <!-- <table class="table table-bordered table-striped table-hover" id="devices-table"> -->
      <table class="table table-bordered table-striped table-hover">
        <tbody>
          <tr>
            <th>名称</th>
            <th :style="{ display: display_type, }">类型</th>
            <th :style="{ display: display_company, }">公司</th>
            <th :style="{ display: display_model, }">型号</th>
            <th :style="{ display: display_sn, }">序列号</th>
            <th :style="{ display: display_version, }">版本</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <tr v-for="device in devices">
         <td>{{device.name}}</td>
         <td :style="{ display: display_type, }">{{device.type}}</td>
         <td :style="{ display: display_company, }">{{device.company}}</td>
         <td :style="{ display: display_model, }">{{device.model}}</td>
         <td :style="{ display: display_sn, }">{{device.sn}}</td>
         <td :style="{ display: display_version, }">{{device.version}}</td>
        <td><img height="20" :src="'/image/'+ device.status+'.png'" class="signal"></td>
         <td><router-link :to="'/admin/station/'+ station + '/device/' + device.id"><img height="20" src="/image/info.png" class="signal"></router-link></td>
     </tr>
     <tr v-if="editable"><td style="text-align: right;" colspan="8">
         <button class="btn btn-primary" @click="go">添加</button>
     </td></tr>
 </tbody>
</table>
</div>
</template>
<script>
    export default {
        props: ['station'],
        data: function () {
            return {
                devices: [],
                editable: thc.can('app_w')||thc.can('sys_w',0),
                station_id: this.$route.params.station,
                windowWidth: window.innerWidth,
                display_type: 'none',
                display_company: 'none',
                display_model: 'none',
                display_sn: 'none',
                display_version: 'none',
            }
        },
        created: function () {
            var self = this;
            this.$http.get('/api/station/' + this.station + '/device').then(function (res) {
                this.devices = res.body;
                this.convert_display_type();
            })
        },
        methods: {
            go: function () {
                this.$router.push({name:'admin-device', params:{station:this.station_id, device:0}, query: {op:'create'}})
            },
            handleWindowResize: function(event) {
              this.windowWidth = event.currentTarget.innerWidth;
            },
            convert_display_type: function(){
              if(window.innerWidth > 550) {
                // this.name_display = 'table-cell';
                this.display_type = 'table-cell';
                this.display_company = 'table-cell';
                this.display_model = 'table-cell';
                this.display_sn = 'table-cell';
                this.display_version = 'table-cell';
              }
              else {
                this.display_type = 'none';
                this.display_company = 'none';
                this.display_model = 'none';
                this.display_sn = 'none';
                this.display_version = 'none';
              }
            },
        },
        watch: {
          windowWidth(curVal, oldVal){
            this.convert_display_type();
          },
        },
        beforeDestroy: function () {
          window.removeEventListener('resize', this.handleWindowResize)
        },
        mounted() {
          window.addEventListener('resize', this.handleWindowResize);
        },
    }
</script>
