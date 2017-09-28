<template>
    <div>
        <div id='qlink'>
            <router-link to="/admin/user">
                <img src="/image/tableg.png"> 用户列表
            </router-link>
        </div>
        <!--用户基本信息-->
        <div class="panel panel-default panel-primary">
            <div class="panel-heading">
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
                            <label for="app_id">所属产品线</label>
                            <select class="form-control" v-model="user.app_id" :disabled="!editing">
                                <option v-for="app in apps" :value="app.id">{{app.name}}</option>
                            </select>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="belongs_code">所属区划</label>
                            <!--                             <div class="input-group">
                                <code-view v-if="!editing" :editing="editing" :search="user.bcode" @code-update="onUserCodeUpdate"></code-view>
                                <code-linkage-view v-if="editing"></code-linkage-view>
                            </div> -->
                            <input v-if="(!editing&&(user.bcode == null))" :disabled="!editing" type="text" class="form-control">
                            <input v-if="(!editing&&(user.bcode != null))" :disabled="!editing" type="text" class="form-control" v-model="user.bcode.merged_name">
                            <code-linkage-view v-if="editing" @codeChanged.self="onUserCodeUpdate"></code-linkage-view>
                        </div>
                    </form>
                    <template v-if="editable">
                        <button v-if="editing" type="submit" @click.prevent="save()" class="btn btn-primary">{{ userButtonHint }}</button>
                        <button v-if="editing" type="submit" @click.prevent="cancel_user()" class="btn btn-default">取消</button>
                        <button v-if="!editing" type="submit" @click.prevent="editing = !editing;isCreate = false;" class="btn btn-primary">修改</button>
                        <!-- <button v-if="!editing" type="submit" @click.prevent="create" class="btn btn-default">创建</button> -->
                        <button v-if="!editing" type="submit" @click.prevent="remove(user.id)" class="btn btn-danger">删除</button>
                    </template>
                </div>
            </div>
        </div>
        <!--权限分配-->
        <div v-if="user.id" class="panel panel-default panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">关联区划及权限配置</h3>
            </div>
            <div class="panel-body">
                <div class="panel">
                    <form class="row" v-if="editing">
                        <div class="form-group col-md-3">
                            <label>区划</label>
                            <code-linkage-view @codeChanged.self="onCodeUpdate"></code-linkage-view>
                        </div>
                        <div class="form-group col-md-3" v-if="code.roles">
                            <label>权限</label>
                            <select class="form-control" v-model="role">
                                <option v-for="cr in code.roles" :value="cr">{{cr.display_name}}</option>
                            </select>
                        </div>
                    </form>
                    <button type="submit" @click.prevent="generatePermission " class="btn btn-primary" v-if="(!code.roles&&editing)">{{ codeButtonHint }}</button>
                    <button type="submit" @click.prevent="attach" class="btn btn-primary" v-if="(code.roles&&editing)">{{ addButtonHint }}</button>
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
    </div>
</template>
<script>
import utils from '../utils'
import bootbox from 'bootbox'
import code_view from './code_view.vue'
import code_linkage_view from './code_linkage_view.vue'
import codeSelector from "./codeSelector.vue"
export default {
    data: () => {
        return {
            editable: thc.can('sys_w', 0),
            user: { app_id: 1, roles: [], bcode: { merged_name: "" } },
            fillable: ['name', 'email', 'password', 'app_id', 'code', 'phone'],
            apps: [],
            roles: [],
            code: "null",
            role: null,
            isCreate: false,
            editing: false,
            userButtonHint: "确定",
            codeButtonHint: "生成角色",
            addButtonHint: "添加权限",
            userBelongCode: null,
        }
    },
    components: {
        'code-view': code_view,
        'code-selector': codeSelector,
        'code-linkage-view': code_linkage_view,
    },
    created: function() {
        var self = this;
        this.$http.get('/api/app').then(function(res) {
            self.apps = res.body;
        });
    },
    mounted: function() {
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
        onCodeUpdate: function(code) {
            this.code = code;
            // console.log("code", this.code.merged_name);
        },
        onUserCodeUpdate: function(code) {
            // this.user.bcode = code;
            this.userBelongCode = code;
            // console.log("userBelongCode", this.userBelongCode.merged_name);
        },
        get: function(merged_name) {
            // console.log(merged_name);
            this.$http.get('/api/code/search?content=' + merged_name).then(function(res) {
                this.codes = res.body;

            });
        },

        save: function() {
            if (this.userBelongCode != null) {
                this.userButtonHint = "上传中";
                var self = this;
                this.$http.get('/api/code/' + this.userBelongCode.id + '?with=roles').then(function(res) {
                    self.user.bcode = res.body;
                    self.user.code = res.body.code;
                    if (self.isCreate) {
                        self.$http.post('/api/user', self.user, { params: { alert: '新建用户' } }).then(function(res) {
                            self.userButtonHint = "确定";
                            self.userBelongCode = null;
                            self.editing = !self.editing;
                            self.$router.push({
                                name: 'admin-user',
                                params: {
                                    user: res.body.id,
                                }
                            });
                        });
                    } else {
                        self.$http.put('/api/user/' + self.user.id, _.pick(self.user, self.fillable), { params: { alert: '更新用户信息' } }).then(function() {
                            self.userButtonHint = "确定";
                            self.userBelongCode = null;
                            self.editing = !self.editing;
                            self.$http.get('/api/user/' + self.$route.params.user + "?with=roles.code,bcode").then(function(res) {
                                self.user = res.body;
                            });
                        });
                    }
                });
            }
        },
        cancel_user: function() {
            if (this.$route.params.user == '0') {
                this.$router.go(-1);
            } else {
                this.userButtonHint = "确定";
                this.userBelongCode = null;

                this.addButtonHint = "添加权限";
                this.role = null;
                this.code = "null";

                this.codeButtonHint = "生成角色";

                this.editing = !this.editing;
            }
        },
        create: function() {
            // this.user = _.reduce(this.user, function (carry, v) {
            //     carry[v] = '';
            //     return carry;
            // }, {});
            this.isCreate = true;
            this.editing = !this.editing;
        },
        remove: function(id) {
            var self = this;
            bootbox.confirm('确认删除？', function(result) {
                if (result) {
                    self.$http.delete('/api/user/' + id).then(function() {
                        self.$router.push({ name: 'admin-users' });
                    })
                }
            })
        },
        load: function() {
            if (this.$route.params.user == 0) {
                return;
            } else {
                this.$http.get('/api/user/' + this.$route.params.user + "?with=roles.code,bcode").then(function(res) {
                    this.user = res.body;
                    this.isCreate = false;
                })
            }
        },
        // codeChanged: function(data){
        //   this.user.code = data.code;
        //   this.user.bcode = data;
        // },
        // watchedCodeChanged: function(data){
        //   var code = data;
        //   this.$http.get('/api/code/'+code.id+'?with=roles').then(function(res){
        //     this.code = res.body;
        //   });
        // },
        detach: function(role, index) {
            var self = this;
            bootbox.confirm('确认删除？', function(result) {
                if (result) {
                    self.$http.post('/api/user/detach', { 'user_id': self.user.id, 'role_id': role.id, 'code_id': role.code.id }, { params: { alert: '删除区划权限' } }).then(function() {
                        self.user.roles.splice(index, 1);
                    })
                }
            })
        },
        attach: function() {
            if (this.role != null) {
                var self = this;
                bootbox.confirm('确认添加？', function(result) {
                    if (result) {
                        self.addButtonHint = "添加中";
                        self.$http.post('/api/user/attach', { 'user_id': self.user.id, 'role_id': self.role.id, 'code_id': self.code.id }, { params: { alert: '添加区划权限' } }).then(function(res) {
                            //self.role.code = self.code;
                            //Vue.set(self.user.roles,  self.user.roles.length, self.role);
                            //self.user.roles.push(self.role);
                            self.addButtonHint = "添加权限";
                            self.role = null;
                            self.code = "null";
                            self.$http.get('/api/user/' + self.$route.params.user + "?with=roles.code,bcode").then(function(res) {
                                self.user = res.body;
                            });
                        })
                    }
                });
            }

        },
        generatePermission: function() {
            if (this.code != "null") {
                this.codeButtonHint = "生成中";
                var self = this;
                this.$http.get('/api/code/' + this.code.id + '?with=roles').then(function(res) {
                    self.codeButtonHint = "生成角色";
                    self.code = res.body;
                });
            }
        },
    }
}
</script>