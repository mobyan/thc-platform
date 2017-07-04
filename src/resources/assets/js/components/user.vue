<template>
    <div>
      <div id='qlink'>
        <router-link :to="admin-user">
                <img src="/image/tableg.png">
                用户列表
              </router-link>
      </div>
      <!--用户基本信息-->
      <div class="panel panel-default panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title">基本信息</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="name">名称</label>
                <input type="text" v-model="user.name" :disabled="!editing" class="form-control" id="name" placeholder="名称">
            </div>
        </div>
      </div>
      <form>
         <div class="form-group">
            <label for="name">名称</label>
            <input type="text" v-model="user.name" :disabled="!editing" class="form-control" id="name" placeholder="名称">
         </div>
         <div class="form-group">
            <label for="email">邮箱</label>
            <input type="text" v-model="user.email" :disabled="!editing" class="form-control" id="email" placeholder="邮箱">
         </div>
         <div class="form-group">
            <label for="phone">手机</label>
            <input type="text" v-model="user.phone" :disabled="!editing" class="form-control" id="phone" placeholder="手机">
         </div>
         <div class="form-group" v-if="isAdmin">
            <label for="app_id">所属产品线</label>
            <select class="form-control" v-model="user.app_id" :disabled="!editing">
              <option v-for="app in apps" :value="app.id" >{{app.name}}</option>
            </select>
         </div>
         <div class="form-group">
            <label for="belongs_code">所属区划</label>
            <input type="text" v-model="user.belongs_code" :disabled="!editing" id="belongs_code" placeholder="区划代码">
         </div>
  <button type="submit" @click.prevent="save()" class="btn btn-default">Submit</button>
</form>
</div>
</template>
<script >
    import utils from '../utils'
    export default {
        data : () => {
            return {
                isAdmin: thc.can('sys_w',0),
                user: {app_id:1, roles:[]},
                apps:[],
                roles:[],
            }
        },
        created: function () {
            var self = this;
            $.when(this.$http.get('/api/app/'),this.$http.get('/api/role/'), this.$http.get('/api/user/' + this.$route.params.user+'?with=roles')).then(function (apps, roles, user) {
                user.body.roles = _.map(user.body.roles, (v) => {
                    return v.id
                });
                self.apps = apps.body;
                self.roles = roles.body;
                self.user = user.body;
            })
        },
        methods: {
            save: function () {
                this.$http.put('/api/user/' + this.$route.params.user, {
                    app_id: this.user.app_id,
                    roles: this.user.roles,
                }, {params:{alert:'更新用户信息'}}).then(res => {
                    utils.alert('success' , res.statusText);
                }, res => {
                    utils.alert('danger' , res.statusText);
                })
            },
        }
    }
</script>
