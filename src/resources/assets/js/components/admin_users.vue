<template>
<div>
  <div v-if="apps.length > 1" style="float: right;">
    <label>产品线：</label><select v-model="currentApp" style="z-index: 9999; position: relative;"><option v-for="(app, index) in apps" :value="app.id">{{app.id}} - {{app.name}}</option></select>&nbsp;&nbsp;&nbsp;
    <button @click="search">搜索</button>
  </div>
  <div class="">
    <table class="table table-bordered table-striped table-hover">
      <tbody>
        <tr class="fatal">
          <th>名称</th>
          <th>邮箱</th>
          <th>手机</th>
          <th>区划</th>
          <th>操作</th>
        </tr>
        <tr v-for="(usr, i) in users" class="">
          <td>{{ usr.name }}</td>
          <td>{{ usr.email }}</td>
          <td>{{ usr.phone }}</td>
          <td>{{ usr.bcode.merged_name}}</td>
          <td>
            <router-link :to="'/admin/user/'+usr.id"><img height="20" src="/image/dashboard.png" class="signal"></router-link>
            <span @click="remove(usr,i)"><img width="16px" height="16px" src="/image/remove.png"></span>
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
        editable: thc.can('sys_w',0),
        users: [],
        apps:[],
        currentApp: null,
      }
    },
    created: function () {
      var self = this;
      this.$http.get('/api/app').then(function(res){
        self.apps = res.body.items;
        self.currentApp = self.apps[0].id;
      }).then(function(){
        this.$http.get('/api/user?with=bcode&app_id='+self.currentApp).then(function(res){
          self.users = res.body;
        });
      });

    },
    methods: {
        go: function () {
            this.$router.push({name:'admin-user', params:{user:0}, query: {op:'create'}})
        },
        search: function(){
            var self = this;
            this.$http.get('/api/user?with=bcode&app_id='+this.currentApp).then(function(res){
              self.users = res.body;
            })
        },
        remove: function(usr, i){
            var self = this;
            this.$http.delete('/api/user/'+usr.id).then(function(res){
              self.users.splice(i, 1);
            })
        }
    }
  }
</script>
