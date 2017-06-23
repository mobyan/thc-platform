<template>
    <div>
      <div id='qlink'>
        <router-link :to="/admin/user">
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
          <div class="col-md-4">
            <img src="/image/noimage.jpg" id="no-image">
          </div>
          <div class="col-md-8">
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
                <div class="form-group">
                   <label for="app_id">所属产品线</label>
                   <select class="form-control" v-model="user.app_id" :disabled="!editing">
                     <option v-for="app in apps" :value="app.id" >{{app.name}}</option>
                   </select>
                </div>
                <div class="form-group">
                   <label for="belongs_code">所属区划</label>
                   <input :disabled="true" type="text" v-model="user.code" class="form-control">
                   <code_view v-show="editing" v-on:codeChangedEvent="codeChanged"></code_view>
                </div>
              </form>
              <template v-if="editable">
                  <button v-if="editing" type="submit" @click.prevent="save()" class="btn btn-primary">确定</button>
                  <button v-if="editing" type="submit" @click.prevent="cancel_user()" class="btn btn-default" >取消</button>
                  <button v-if="!editing" type="submit" @click.prevent="editing = !editing;isCreate = false;" class="btn btn-primary">修改</button>
                  <!-- <button v-if="!editing" type="submit" @click.prevent="create" class="btn btn-default">创建</button> -->
                  <button v-if="!editing" type="submit" @click.prevent="remove(user.id)" class="btn btn-danger">删除</button>
              </template>
          </div>
        </div>
      </div>
      <!--权限分配-->

      <div v-if="user.id" class="panel panel-default panel-primary">
        <div class="panel-heading" >
            <h3 class="panel-title">关联区划及权限配置</h3>
        </div>
        <div class="panel-body">
            <div class="panel">
              <div class="form-group"><label>区划</label>
                <input :disabled="true" type="text" v-model="code" class="form-control">
                <code_view v-show="editing" v-on:codeChangedEvent="codeChanged"></code_view>
              </div>
              <div class="form-group"><label>权限</label>
                <select class="form-control" v-model="role">
                    <option v-for="(role, i) in code.roles" :value="role">{{role.display_name}}</option>
                </select>
              </div>
              <button type="submit" @click.prevent="attach" class="btn btn-primary">提交</button>
            </div>
            <div>
              <tabel class="table table-bordered table-striped table-hover">
                <tbody>
                  <tr class="fatal">
                    <th>区划</th>
                    <th>权限</th>
                    <th>操作</th>
                  </tr>
                  <tr v-for="(role, index) in user.roles">
                    <td>{{ role.code.merged_name}}</td>
                    <td>{{ role.display_name}}</td>
                    <td style="vertical-align: middle;width:33px;">
                      <span @click="remove(role, index)"><img width="16px" height="16px" src="/image/remove.png"></span>
                    </td>
                  </tr>
                </tbody>
              </tabel>
            </div>
        </div>
</div>
</template>
<script >
    import utils from '../utils'
    import bootbox from 'bootbox'
    import code_view from './code_view.vue'
    export default {
        data : () => {
            return {
                editable: thc.can('sys_w',0),
                user: {app_id:1, roles:[]},
                apps:[],
                roles:[],
                code: null,
                role: null,
            }
        },
        components:{
          code_view
        },
        created: function () {
            var self = this;
            $.when(this.$http.get('/api/app/'),this.$http.get('/api/role/'), this.$http.get('/api/user/' + this.$route.params.user+'?with=roles')).then(function (apps, roles, user) {
                user.body.roles = _.map(user.body.roles, (v) => {
                    return v.id
                });
                self.apps = apps.body.items;
                self.roles = roles.body.items;
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
            cancel_user: function(){
              if (this.$route.params.user == '0') {
                this.$router.go(-1);
              }
              else{
                this.editing = !this.editing;
              }
            },
            create: function () {
                this.user = _.reduce(this.user, function (carry, v) {
                    carry[v] = '';
                    return carry;
                }, {});
                this.isCreate = true;
                this.editing = !this.editing;
            },
            remove: function (id) {
                var self = this;
                bootbox.confirm('确认删除？', function (result) {
                    if (result) {
                        self.$http.delete('/api/user/' + id).then(function () {
                            self.$router.push({name:'admin-users'});
                        })
                    }
              })
            },
            detach: function (role, index) {
                var self = this;
                bootbox.confirm('确认删除？', function (result) {
                    if (result) {
                        self.$http.post('/api/user/detach',{'user_id': self.user.id, 'role_id': role.id, 'code_id': role.code.id}, {params:{alert:'删除区划权限'}}).then(function () {
                            self.user.roles.splice(index, 1);
                        })
                    }
              })
            },
            attach: function (){
              var self = this;
              bootbox.confirm('确认添加？', function( result){
                    if(result){
                      self.$http.post('api/user/attach', {'user_id': self.user.id, 'role_id': self.role.id, 'code_id': self.code.id},{params:{alert:'添加区划权限'}}).then(function (){
                        self.user.roles.push(self.role);
                      })
                    }
              });
            }
        }
    }
</script>
