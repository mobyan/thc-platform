<template>
<div>
  <div class="">
    <label>当前所属区划：</label><select v-if="user" v-model="currentCode" style="z-index: 9999; position: relative;"><option v-for="(code, index) in regioncodes" :value="code.code">{{code.code}} - {{code.merged_name}}</option></select>&nbsp;&nbsp;&nbsp;
  </div>
  <div class="">
    <table class="table table-bordered table-striped table-hover">
      <tbody>
        <tr class="fatal">
          <th>名称</th>
          <th>email</th>
          <th>手机</th>
          <th>区划</th>
          <th>操作</th>
        </tr>
        <tr v-for="usr in users" class="">
          <td>{{ usr.name }}</td>
          <td>{{ usr.email }}</td>
          <td>{{ usr.phone }}</td>
          <td>{{ }}
          <td><img height="20" :src="'/image/'+ station.status+'.png'" class="signal"></td>
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
</div>
</template>

<script>
  export default {
    data: function () {
      return {
        editable: thc.can('app_w')|| thc.can('sys_w',0),
        isAdmin: thc.can('sys_w', 0),
        users: [],
        regioncodes: [],
        currentCode: null,
      }
    },
    created: function () {
      var self = this;
      this.$http.get('/api/regioncode').then(function(res){
        this.regioncodes = res.body.items;
      });
      this.currentCode = this.regioncodes[0];
      this.$http.get('/api/user?code='+this.currentCode).then(function (res) {
        this.users = res.body.items;
      })
    },
    watch: {
      currentCode: function () {
        this.$http.get('/api/user?code='+this.currentCode).then(function(res){
        this.users = res.body.items;
        })
      }
    },
    methods: {
        go: function () {
            this.$router.push({name:'admin_user', params:{user:0}, query: {op:'create'}})
        }
    }
  }
</script>
