<template>
<div>
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
        <tr v-for="(usr, index) in users" class="">
          <td>{{ usr.name }}</td>
          <td>{{ usr.email }}</td>
          <td>{{ usr.phone }}</td>
          <td>{{ usr.brcode.merged_name}}</td>
          <td>
            <router-link :to="'/admin/user/'+usr.id/reset"><img height="20" src="/image/info.png" class="signal"></router-link>
            <router-link :to="'/admin/user/'+usr.id"><img height="20" src="/image/dashboard.png" class="signal"></router-link>
            <span @click="removeUser(usr,index)"><img width="16px" height="16px" src="/image/remove.png"></span>
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
      }
    },
    created: function () {
      var self = this;
      this.$http.get('/api/user').then(function(res){
        self.users = res.body;
      });
    },
    methods: {
        go: function () {
            this.$router.push({name:'admin-user', params:{user:0}, query: {op:'create'}})
        }
    }
  }
</script>
