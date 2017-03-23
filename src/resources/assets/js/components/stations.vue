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
          <td><img height="20" src="/image/warning.png" class="signal"></td>
          <td>
            <router-link :to="'/station/'+station.id"><img height="20" src="/image/info.png" class="signal"></router-link>              
            <router-link :to="'/station/'+station.id+'/dashboard'"><img height="20" src="/image/dashboard.png" class="signal"></router-link>
          </td>
        </tr>
             <tr v-if="editable"><td style="text-align: right;" colspan="7">
         <button class="btn btn-primary" @click="go">添加</button>
     </td></tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    data: function () {
      return {
        editable: thc.can('app_w'),
        stations: [],
      }
    },
    created: function () {
      var self = this;
      this.$http.get('/api/station').then(function (res) {
        this.stations = res.body.items;
      })
    },
    methods: {
        go: function () {
            this.$router.push({name:'station', params:{station:0}, query: {op:'create'}})
        }
    }
  }
</script>