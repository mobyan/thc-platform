<template>
    <div>
      <div id='qlink'>
        <router-link to="/users">
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
                <div class="form-group col-md-6">
                   <label for="name">名称</label>
                   <input type="text" v-model="user.name" :disabled="!editing" class="form-control" id="name" placeholder="名称">
                </div>
                <div class="form-group  col-md-6">
                   <label for="email">邮箱</label>
                   <input type="text" v-model="user.email" :disabled="!editing" class="form-control" id="email" placeholder="邮箱">
                </div>
                <div class="form-group  col-md-6">
                   <label for="phone">手机</label>
                   <input type="text" v-model="user.phone" :disabled="!editing" class="form-control" id="phone" placeholder="手机">
                </div>
                <div class="form-group col-md-6" v-if="isCreate">
                    <label for="password">密码</label>
                    <input id="password" type="password" class="form-control" name="password" v-model="user.password" required>
                </div>

                <div class="form-group col-md-6" v-if="isCreate">
                    <label for="password-confirm">密码确认</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="user.password_confirmation" required>
                </div>

                <div class="form-group  col-md-6">
                   <label for="belongs_code">所属区划</label>
                   <div class="input-group">
                     <select class="form-control" v-model="user.code" :disabled="!editing">
                       <option v-for="sub in subs" :value="sub.code" >{{sub.merged_name}}</option>
                     </select>

                   </div>
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
              <form class="row">
                <div class="form-group col-md-3">
                  <label>区划</label>
                  <div class="input-group">
                    <select class="form-control" v-model="code">
                      <option v-for="sub in subs" :value="sub" >{{sub.merged_name}}</option>
                    </select>
                    <!--<input class="form-control" v-model="code.merged_name" @keydown.enter="searchCode()"></input>
                    <div class="input-group-btn">
                      <button @click="searchCode()" class="btn btn-white btn-primary"><i class="fa fa-search"></button>
                      <button @click="clearCode()" class="btn btn-white btn-primary"><i class="fa fa-refresh"></button>
                    </div>
                    <div class="search-select">
                        <transition-group name="itemfade" tag="ul" mode="out-in" v-cloak v-show="isShow" style="z-index: 9999; position: relative;">
                            <li v-for="(cv,index) in codes" :class="{selectback:index==now}" :key="index" @click.prevent="selectCode(index)" class="search-select-option search-select-list">
                                {{cv.merged_name}}
                            </li>
                        </transition-group>
                    </div>-->
                  </div>
                  <!--<input :disabled="true" type="text" v-model="code.merged_name" class="form-control">
                  <code_view v-on:codeChangedEvent="watchedCodeChanged"></code_view>-->
                </div>
                <div class="form-group col-md-3" v-if="code"><label>权限</label>
                  <select class="form-control" v-model="role">
                      <option v-for="cr in code.roles" :value="cr">{{cr.display_name}}</option>
                  </select>
                </div>

              </form>
              <button type="submit" @click.prevent="attach" class="btn btn-primary">提交</button>

              <table class="table table-bordered table-striped table-hover" v-if="user.roles">
                <tbody>
                  <tr class="fatal">
                    <th>区划</th>
                    <th>权限</th>
                    <th>操作</th>
                  </tr>
                  <tr v-for="(r, i) in user.roles">
                    <td>{{ r.code.merged_name}}</td>
                    <td>{{ r.display_name}}</td>
                    <td style="vertical-align: middle;width:33px;">
                      <span @click="detach(r, i)"><img width="16px" height="16px" src="/image/remove.png"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
      </div>
</template>
<script >
    import utils from '../utils'
    import bootbox from 'bootbox'

    export default {
        data: function(){
            return {
                editable: thc.can('app_w'),
                editing: false,
                user: {app_id:1, roles:[],code:""},
                subs:[],
                code: null,
            }
        },
        created: function(){
          this.$http.get('/api/code/subs?with=roles').then(function(res){
              this.subs = res.body;
              this.code = this.subs[0];
          });
          // this.load();
        },
        mounted: function () {

          if (this.$route.query.op == 'create') {
            this.create();
          } else {
            this.load();
          }
        },
        watch: {
          '$route': 'load',
        },
        methods: {
          get: function(merged_name) {
              console.log(merged_name);
              this.$http.get('/api/code/search?content='+merged_name).then(function(res) {
                  this.codes = res.body;

              });
          },
          save: function () {
              if (this.isCreate) {
                  this.$http.post('/api/user', this.user, {params:{alert:'新建用户'}}).then(function (res) {
                      this.editing = !this.editing;
                      this.$router.push({
                          name: 'admin-user',
                          params: {
                              user: res.body.id,
                          }
                      })
                  });
              } else {
                  this.$http.put('/api/user/'+this.user.id, _.pick(this.user, this.fillable), {params:{alert:'更新用户信息'}}).then(function () {
                      this.editing = !this.editing;
                  });
              }
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
          load: function () {

            if(this.$route.params.user == 0){
              return;
            }
            else{
              this.$http.get('/api/user/'+this.$route.params.user+"?with=roles.code").then(function (res) {
                this.user = res.body;
              })
            }
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
                    self.$http.post('/api/user/attach', {'user_id': self.user.id, 'role_id': self.role.id, 'code_id': self.code.id},{params:{alert:'添加区划权限'}}).then(function (res){
                      //self.role.code = self.code;
                      //Vue.set(self.user.roles,  self.user.roles.length, self.role);
                      //self.user.roles.push(self.role);
                      self.user = res.body;
                    })
                  }
            });
          }
        }
    }
</script>
